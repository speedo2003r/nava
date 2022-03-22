<template>
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor p-0" id="kt_content">
                    <div class="map h-100">
                        <gmap-map
                            :center="center"
                            :zoom="zoom"
                            map-type-id="terrain"
                            style="width: 100%; height: 100%;border: 0"
                            >
                            <gmap-marker
                                :key="index"
                                v-for="(assReq, index) in assigned"
                                :position="assReq.driver.position"
                                :clickable="true"
                                :draggable="false"
                                @click="selectedRequest = assReq"
                                :icon="{url: (selectedRequest.id == assReq.id) ? asset + 'images/marker-selected.png' : asset + 'images/marker.png'}"
                                :visible="assReq.driver.position.lat != 0"
                                >
                            </gmap-marker>
                            <gmap-marker
                                :key="index+1000"
                                v-for="(assReq1, index) in assigned"
                                :position="{lat: Number(assReq1.latitude), lng: Number(assReq1.longitude)}"
                                :draggable="false"
                                @click="selectedRequest = assReq1"
                                :visible="selectedRequest.id == assReq1.id"
                                :lable="{text: 'Destination', color: 'white'}"
                                :icon="{url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'}"
                                opacity="0.5"
                                >
                            </gmap-marker>

                        </gmap-map>
                    </div>


                <div class="track-side">
                    <div class="items">
                        <div class="track-head">
                            <ul class="list-unstyled">
                                <li> {{unassigned_label}} : <span> {{ unassigned.length }} </span> </li>
                                <li> {{assigned_label}} : <span> {{ assigned.length }} </span> </li>
                            </ul>
                        </div>
                        <ul class="tabs track-tab mb-4">
                            <li class="tab-link current" data-tab="tab-1">{{unassigned_label}}</li>
                            <li class="tab-link " data-tab="tab-2"> {{assigned_label}}</li>
                        </ul>
                        <div class="ditials">
                            <div id="tab-1" class="tab-content current">
                                <div
                                v-for="req in unassigned"
                                class="driver-details"
                                >
                                    <div class="div">
                                        <div class="assign">
                                            <a :href="url + '/' + req.id + '/assign'" class="btn btn-success"> {{assign_label}} </a>
                                        </div>
                                    </div>
                                    <div class="div">
                                        <div class="address">
                                            <h5 class="addres-info">
                                                {{address_label}} <br> <span> {{ req.district.title }} </span>
                                            </h5>
                                        </div>
                                        <div class="address">
                                            <h5 class="addres-info">
                                                {{service_label}} <br> <span> {{ req.service.title }} </span>
                                            </h5>
                                        </div>
                                        <div class="requist-id">
                                            <h5> {{request_no_label}} <br> <a href="#"> <span> {{ req.id }} </span> </a> </h5>
                                        </div>
                                        <div>
                                            <h5> {{client_name_label}} <br> <span> {{ (req.client != undefined) ? req.client.name : '-----'}} </span> </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-content">
                                <div
                                v-for="request in assigned"
                                :class="{selected: request.id == selectedRequest.id}"
                                @click="selectedRequest = request; centerMap(request.driver.position);"
                                class="driver-details"
                                >
                                    <div class="div">
                                        <div>
                                            <h5> {{driver_name_label}} <br> <span> {{request.driver.name}} </span> </h5>
                                        </div>
                                        <div>
                                            <h5> {{technician_name_label}} <br> <span> {{ request.technician.name }} </span> </h5>
                                        </div>
                                        <a href="" class="requist-id">
                                            <h5> {{request_no_label}} <br> <span> {{ request.id }} </span> </h5>
                                        </a>
                                    </div>
                                    <div class="states text-center">
                                        <div>
                                            <span :class="_.includes(['in-progress', 'finished'], request.status) ? 'states-bg' : ''" class="state"></span>
                                            <span>{{start_work_label}}</span>
                                        </div>
                                        <div>
                                            <span :class="_.includes(['in-progress', 'finished', 'arrived'], request.status) ? 'states-bg' : ''" class="state"></span>
                                            <span class="title">{{arrived_label}}</span>
                                        </div>

                                        <div>
                                            <span :class="_.includes(['in-progress', 'finished', 'arrived', 'on-way'], request.status) ? 'states-bg' : ''" class="state"></span>
                                            <span class="title">{{on_the_way_label}}</span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                </div>
</template>

<script>
    export default {
        data() {
            return {
                center: {
                    lat: 30,
                    lng: 30
                },
                selectedRequest: {},
                isConnected: false,
                zoom: 8,
                assigned: [],
                unassigned: [],
                _: null,
            }
        },
        props: [
            'asset',
            'assignedJson',
            'unassignedJson',
            'url',
            'unassigned_label',
            'assigned_label',
            'assign_label',
            'address_label',
            'service_label',
            'request_no_label',
            'client_name_label',
            'driver_name_label',
            'technician_name_label',
            'start_work_label',
            'arrived_label',
            'on_the_way_label'
        ],
        created: function(){

            console.log(this.asset);
            this.assigned = JSON.parse(this.assignedJson);
            this.unassigned = JSON.parse(this.unassignedJson);
            this._ = _;

        },
        methods: {
            centerMap(pos){
                if(pos.lat != 0){
                    this.center = pos;
                    this.zoom=15;
                }
            }
        },
        sockets: {
            connect() {
                this.isConnected = true;
            },
            disconnect() {
                this.isConnected = false;
            },

            /*
             * Fired when the server sends something on the "driver" channel.
             * Driver object:
             * {
             *   id: Integer,
             *   name: String,
             *   branch: String,
             *   position: {
             *     lat: Float,
             *     lng: Float
             *   }
             * }
            */ 
            driver(driver) {
                let inList = _.find(this.assigned, { driver_id: driver.id });
                if(inList) {
                    inList.driver.position = driver.position;
                }else{
                    // this.drivers.push(driver);
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .drivers-list {
        list-style: none;
        padding: 0;
        background: #fff;
        height: 500px;
        overflow-y: scroll;

        li {
            border-bottom: 1px solid #f4f4f4;
            padding: 10px;
            cursor: pointer;
            &.selected {
                background: #3b8dbc;
                color: #fff;
            }

            &:hover {
                background: rgba(59, 141, 188, 0.8);
                color: #fff;
            }


            h3 {
                margin: 0;
                font-size: 14px;
                font-weight: bold;
            }
            p {
                font-size: 13px;
            }
        }
    }
</style>
