<template>
  <div>
    <loading
      :active.sync="isLoading"
      :can-cancel="false"
      :on-cancel="onCancel"
      :is-full-page="fullPage"
      :loader="type"
      :color="loaderColor"
      :hight="loaderHight"
      :width="loaderWidth"
    ></loading>


        <!-- /.box-header -->
      <div :id="'chatboxscroll-' + otherUser.id"
          v-chat-scroll="{always: false, smooth: true, scrollonremoved:true, smoothonremoved: false}"
          class="chat-content over_scroll_chat height_chat" style="height: 300px;overflow: auto">
          <div class="sent_chat"
               v-for="messagePacket in allMsgs"
               :key="messagePacket.id"
               :class="{ 'content_sent' : (messagePacket.is_sender == 1),'content_receive' : (messagePacket.is_sender == 0) }">
              <div class="receive"
                   :class="{ 'sent' : (messagePacket.is_sender == 1), 'receive' : (messagePacket.is_sender != 1) }">
                  <p v-if="messagePacket.message.type == 'text'"
                  :class="{ 'pull-right direct-chat-text' : (messagePacket.is_sender == 1), 'pull-left direct-chat-text' : (messagePacket.is_sender != 1) }"
                  style="display: inline-block;margin-left: 1px;margin-left: 1px;word-break: break-all;padding: 3px 10px;">{{messagePacket.message.body}}</p>
                  <div
                      v-if="messagePacket.message.type == 'file'"
                      :class="{ 'pull-left' : (messagePacket.is_sender == 1), 'pull-left' : (messagePacket.is_sender != 1) }"
                      class="clearfix"
                      style="display: inline-block;margin-left: 1px;margin-left: 1px;word-break: break-all;padding: 3px 3px;"
                  >
                      <a
                          v-if="messagePacket.message.body.split('.').pop() != 'pdf'"
                          :href="origin+'/storage/images/rooms/'+room.id+'/' + messagePacket.message.body"
                          download
                          title="image"
                          target="_new"
                      >
                          <img height="110px;" width="110px;" :src="origin+'/storage/images/rooms/'+room.id+'/' + messagePacket.message.body" />
                      </a>
                      <a
                          v-else
                          :href="origin+'/storage/images/rooms/'+room.id+'/' + messagePacket.message.body"
                          download
                          title="pdf"
                          target="_new"
                          class="direct-chat-text"
                      >
                  <span class="info-box-icon" style="color: white;background:none;">
                    <i class="fa fa-paperclip"></i>
                  </span>
                      </a>
                  </div>
              </div>
              <div class="direct-chat-info clearfix">
                  <small class="font_12 pull-right">{{messagePacket.message.created_at | moment("calendar")}} رساله من {{messagePacket.message.user_name}}</small>
              </div>
          </div>
      </div>

      <div class="writ_massage d-flex">
          <form class="form d-flex flex-grow-1">
              <div class="input-group">
                  <!-- <input
                    name="message"
                    :id="'msginput-' + otherUser.id"
                    v-model.trim="message"
                    placeholder="Type Message And Hit Enter"
                    class="form-control"
                    type="text"
                    v-on:keydown="sendMessage($event)"
                  />-->
                  <textarea
                      class="form-control"
                      :id="'msginput-' + otherUser.id"
                      placeholder="اكتب رسالتك هـنا"
                      v-model="message"
                      @keypress="startTyping"
                      @keyup.enter.exact="addMessage"
                      @keydown.enter.shift.exact="newline"
                      :readonly="fileChosen != ''"
                  ></textarea>
                  <i
                      class="fa fa-times fa-3"
                      style="color:red;margin:0 20px"
                      v-show="fileChosen != ''"
                      @click="clearInput"
                  ></i>
                  <span class="input-group-btn">
              <div class="btn btn-default btn-file">
                <i class="fa fa-paperclip"></i>
                  <!-- <input name="attachment" type="file" v-on:change="file($event)" /> -->
                <input
                    type="file"
                    id="file"
                    ref="file"
                    @change="handleFileUpload()"
                    accept="image/jpeg, image/gif, image/png, application/pdf, image/jpg"
                />
              </div>
            </span>
              </div>
<!--              <button class="" @click="addMessage" type="button" style="height: 55px;margin-top: 17px;">-->
<!--                  <i class="fas fa-paper-plane" aria-hidden="true"></i>-->
<!--                  ارسال-->
<!--              </button>-->
          </form>
      </div>
  </div>
</template>

<script>
export default {
    props:[
        'order',
        'room_id',
    ],
  data: function() {
    return {
      isLoading: false,
      fullPage: true,
      type: "dots",
      loaderColor: "blue",
      loaderHight: 128,
      loaderWidth: 128,

      origin: Origin,
      message: "",
      typing: false,
      //timeout: "",
      //socket: "",
      allMsgs: [],
      fileChosen: "",
      otherRoomUsers: [],

      user_id: USER_ID,
      otherUser:'',
      room: {}
    };
  },
  components: {
    Loading
  },
  // sockets: {
  //   addMessageResponse(data) {
  //     if (data.room_id == this.room.id && this.user_id != data.user_id) {
  //       data["is_sender"] = "0";
  //       this.allMsgs.push(data);
  //       this.typing = false;
  //     }
  //   },
    // ResTyping(data) {
    //   if (data.room_id == this.room.id && this.user_id != data.user_id) {
    //     this.typing = true;
    //     setInterval(() => {
    //       this.typing = false;
    //     }, 5000);
    //   }
    // }
  // },
  methods: {
    startTyping() {
        // window.Echo.private(`startTyping.${this.room.user_id}`)
    },
    clearInput() {
      this.fileChosen = "";
      this.message = "";
      this.$refs.file.value = "";
    },
    newline() {
      this.value = `${this.value}\n`;
    },
    handleFileUpload() {
      this.fileChosen = this.$refs.file.files[0];
      this.message = this.$refs.file.files[0].name;
    },
    addMessage() {
      if (this.fileChosen != "") {
        // validate file size
        if (this.fileChosen.size > 10000000) {
          this.$swal({
            title: "max file size 10M ",
            type: "error"
          });
          this.fileChosen = "";
          this.message = "";
          return false;
        }

        // upload file
        let formData = new FormData();
        formData.append("file", this.fileChosen);
        formData.append("room_id", this.room.id);
        formData.append("user_id", this.user_id);

        //console.log(formData);
        this.uploadFile(formData);
      } else if (this.message.trim() == "") {
        return false;
      } else {
        // send text message
        this.sendMessage(this.message);
      }
    },
      listenForNewMessage() {
          Echo.private('rooms.' + this.room_id)
              .listen('MessageSent', (e) => {
                  if(e.user_id != this.user_id){
                      this.allMsgs.push(e)
                  }
                  // $("#messages").animate({ scrollTop: $(document).height() }, "slow");
              });
      },
    uploadFile(formData) {
      this.isLoading = true;

      // POST /someUrl
      this.$http
        .post("/chats/store", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(
          response => {
            this.isLoading = false;

            if (response.body.status == 1) {
              this.message = "";
              this.fileChosen = "";

              this.allMsgs.push(response.body.data);
              //console.log(response.body.data);
            } else if (response.body.status == 2) {
              location.reload();
            } else {
              this.$swal({
                title: response.body.message,
                type: "error"
              });
            }
          },
          response => {
            // console.log(response.body);
            //error callback
            this.isLoading = false;
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
      getUser(id){
    this.$http
        .post(`/ajax/getUser/${id}`)
        .then(
            response => {
                this.otherUser = response.body.data;
            })
      },
    sendMessage($msg) {
      //this.isLoading = true;

      // POST /someUrl
      this.$http
        .post("/chats/store", {
          message: $msg,
          room_id: this.room.id,
          user_id: this.user_id
        })
        .then(
          response => {
            //this.isLoading = false;

            if (response.body.status == 1) {
              this.message = "";

              this.allMsgs.push(response.body.data);
            } else if (response.body.status == 2) {
              location.reload();
            } else {
              this.$swal({
                title: response.body.message,
                type: "error"
              });
            }
          },
          response => {
            console.log(response.body);
            //error callback
            //this.isLoading = false;
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
    onCancel() {
      // for loader
      console.log("User cancelled the loader.");
    }
  },
  created() {
      var that = this;
    this.$http
      .get(`/create-private-room/${that.order}`)
      .then(response => {
          that.room = response.body.room;
          that.allMsgs = response.body.messages;
        //console.log(response.body.room.id.toString());
      });
    this.otherRoomUsers.push(this.otherUser);


  },
  mounted() {
      this.getUser(1)
      this.listenForNewMessage();
    //console.log("box chat instance mounted");
  },
  beforeDestroyed(){

  },
  destroyed(){
  },
};
</script>

<style lang="scss" scoped>
</style>
