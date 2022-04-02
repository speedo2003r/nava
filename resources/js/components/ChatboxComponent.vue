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
    <div class="chat_box" :id="'chatbox-' + otherUser.id" style="left:270px">
      <div class="box box-primary direct-chat direct-chat-primary">
        <div class="box-header with-border" style="text-align:left">
          <h3 class="box-title">{{ otherUser.name }}</h3>
          <span v-if="typing"><img :src="origin + '/images/typing1.gif'" alt="typine" width="20%" height="10%"></span>
          <div class="box-tools pull-left">
            <button
              type="button"
              data-widget="collapse"
              @click="chatBoxMinimize(otherUser.id)"
            >
              <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-box-tool" @click="chatBoxClose(otherUser.id)">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>

        <!-- /.box-header -->
        <div style class="box-body">
          <div
            class="direct-chat-messages"
            :id="'chatboxscroll-' + otherUser.id"
            v-chat-scroll="{always: false, smooth: true, scrollonremoved:true, smoothonremoved: false}"
          >
            <div
              v-for="messagePacket in allMsgs"
              :key="messagePacket.id"
              class="direct-chat-msg"
              :class="{ 'left' : (messagePacket.is_sender == 1),'right' : (messagePacket.is_sender == 0) }"
            >
              <div class="direct-chat-info clearfix">
                <small
                  class="direct-chat-timestamp"
                  :class="{ 'pull-left' : (messagePacket.is_sender == 1), 'pull-right' : (messagePacket.is_sender != 1) }"
                >{{messagePacket.message.created_at | moment("calendar")}}</small>
              </div>

              <div
                v-if="messagePacket.message.type == 'text'"
                :class="{ 'pull-left' : (messagePacket.is_sender == 1), 'pull-right' : (messagePacket.is_sender != 1) }"
                class="direct-chat-text clearfix"
                style="display: inline-block;margin-left: 1px;margin-left: 1px;word-break: break-all;padding: 3px 10px;"
              >{{messagePacket.message.body}}</div>

              <div
                v-if="messagePacket.message.type == 'file'"
                :class="{ 'pull-left' : (messagePacket.is_sender == 1), 'pull-left' : (messagePacket.is_sender != 1) }"
                class="direct-chat-text clearfix"
                style="display: inline-block;margin-left: 1px;margin-left: 1px;word-break: break-all;padding: 3px 3px;"
              >
                <a
                  v-if="messagePacket.message.body.split('.').pop() != 'pdf'"
                  :href="origin + messagePacket.message.body"
                  download
                  title="image"
                  target="_new"
                >
                  <img height="110px;" width="110px;" :src="origin + messagePacket.message.body" />
                </a>
                <a
                  v-else
                  :href="origin + messagePacket.message.body"
                  download
                  title="pdf"
                  target="_new"
                >
                  <span class="info-box-icon" style="color: white;background:none;">
                    <i class="fa fa-paperclip"></i>
                  </span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div style="display: block;" class="box-footer">
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
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
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
      room: {}
    };
  },
  props: ["otherUser", "chatBoxClose", "chatBoxMinimize"],
  components: {
    Loading
  },
  sockets: {
    addMessageResponse(data) {
      if (data.room_id == this.room.id && this.user_id != data.user_id) {
        data["is_sender"] = "0";
        this.allMsgs.push(data);
        this.typing = false;
      }
    },
    ResTyping(data) {
      if (data.room_id == this.room.id && this.user_id != data.user_id) {
        this.typing = true;
        setInterval(() => {
          this.typing = false;
        }, 5000);
      }
    }
  },
  methods: {
    startTyping() {
      this.$socket.client.emit("startTyping", {'room_id' : this.room.id,'users': this.otherRoomUsers});
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
    uploadFile(formData) {
      this.isLoading = true;

      // POST /someUrl
      this.$http
        .post("/admin/chats/store", formData, {
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
              this.$socket.client.emit("addMessage", response.body.data);
              //console.log(response.body.data);
              //this.$root.$emit('new-message', response.body.data)
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
            this.isLoading = false;
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
    sendMessage($msg) {
      //this.isLoading = true;

      // POST /someUrl
      this.$http
        .post("/admin/chats/store", {
          message: $msg,
          room_id: this.room.id,
          user_id: this.user_id
        })
        .then(
          response => {
            //this.isLoading = false;

            if (response.body.status == 1) {
              this.message = "";
              console.log(this.allMsgs);
              this.allMsgs.push(response.body.data);
              this.$socket.client.emit("addMessage", response.body.data);
              //this.$root.$emit('new-message', response.body.data)
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
    this.$http
      .get("/admin/create-private-room/" + this.otherUser.id)
      .then(response => {
        this.room = response.body.room;
        this.allMsgs = response.body.messages;
        this.$socket.client.emit("createOrJoinRoom", response.body.room.id);
        //console.log(response.body.room.id.toString());
      });
    this.otherRoomUsers.push(this.otherUser);


  },
  mounted() {
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
