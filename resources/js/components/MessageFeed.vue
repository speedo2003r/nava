<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :class="`message${message.to == contact.id ? ' sent': ' received'}`" :key="message.id">
                <div class="text">
                    {{message.text}}
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props:['contact','messages'],
        data(){
            return {

            }
        },
        methods:{
            scrollToBottom(){
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                },50)
            }
        },
        watch:{
            contact(contact){
                this.scrollToBottom();
            },
            messages(messages){
                this.scrollToBottom();
            },
        }
    }
</script>

<style scoped>
    .feed{
        overflow-y: scroll;
    }
    .feed ul{
        list-style: none;
    }
    li.message{
        margin: 10px;
        padding: 10px;
        clear: both;
    }
    li.message.received{
        text-align: right;
        background: #999;
        display: inline-block;
        float: right;
    }
    li.message.sent{
        text-align: left;
        background: #ccc;
        display: inline-block;
        float: left;
    }
</style>