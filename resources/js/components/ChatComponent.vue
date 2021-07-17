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

    <div class="chat-content" v-chat-scroll="{always: false, smooth: true, scrollonremoved:true, smoothonremoved: false}">
      <div v-for="(message,index) in allMsgs" :key="index">
        <div class="people-blocks recieve" v-if="message.is_sender == 0">
          <div class="desc" v-if="message.message.type == 'text'">
            <p>{{message.message.body}}</p>
          </div>
          <div class="file" v-else-if="message.message.type == 'file'">
            <a
              v-if="message.message.body.split('.').pop() == 'pdf'"
              :href="origin + message.message.body"
              target="_blank"
            >
              <img :src="origin + 'images/pdfimg.jpeg'" alt="pdf" width="50" height="50" />
            </a>
            <a v-else :href="origin + message.message.body" target="_blank">
              <img :src="origin + message.message.body" alt="image" width="50" height="50" />
            </a>
          </div>
          <div class="time">
            <span>{{message.message.created_at | moment("calendar")}}</span>
          </div>
        </div>
        <div class="people-blocks send" v-else>
          <div class="desc" v-if="message.message.type == 'text'">
            <p>{{message.message.body}}</p>
          </div>
          <div class="file" v-else-if="message.message.type == 'file'">
            <a
              v-if="message.message.body.split('.').pop() == 'pdf'"
              :href="origin + message.message.body"
              target="_blank"
            >
              <img :src="origin + 'images/pdfimg.jpeg'" alt="pdf" width="50" height="50" />
            </a>
            <a v-else :href="origin + message.message.body" target="_blank">
              <img :src="origin + message.message.body" alt="image" width="50" height="50" />
            </a>
          </div>
          <div class="time">
            <span>{{message.message.created_at | moment("calendar")}}</span>
          </div>
        </div>
      </div>
      <div class="text-center" v-show="typing">
        <img :src="origin + '/images/typing1.gif'" alt="typing" width="200" height="30" />
      </div>
    </div>

    <div class="chat-footer">
      <form id="form" action>
        <div class="form-group">
          <textarea
            class="form-group"
            id="input-custom-size"
            placeholder="اكتب رسالتك هـنا"
            v-model="message"
            @keypress="startTyping"
            @keyup.enter.exact="addMessage"
            @keydown.enter.shift.exact="newline"
            :readonly="fileChosen != ''"
          ></textarea>
        </div>
        <div class="form-group file">
          <input
            type="file"
            id="file"
            ref="file"
            @change="handleFileUpload()"
            accept="image/jpeg, image/gif, image/png, application/pdf, image/jpg"
          />
          <i class="fas fa-paperclip"></i>
        </div>
        <div class="form-group sub d-flex">
          <i
            class="fa fa-times fa-3"
            style="color:red;margin:0 20px"
            v-show="fileChosen != ''"
            @click="clearInput"
          >x</i>
          <button class="site-btn" id="myBtn" type="submit" @click.prevent="addMessage">
              send
            <i class="fas fa-paper-plane"></i>
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
//import moment from 'moment';
export default {
  data() {
    return {
      isLoading: false,
      fullPage: true,
      type: "dots",
      loaderColor: "blue",
      loaderHight: 128,
      loaderWidth: 128,

      origin: window.location.origin ,
      message: "",
      typing: false,
      timeout: "",
      socket: "",
      allMsgs: [],
      fileChosen: "",
      otherRoomUsers:[],

      user_id:USER_ID,
    };
  },
  props: ["messages", "room"],
  computed: {},
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
        this.typing=true;
        setInterval(()=>{
          this.typing=false
        },3000);
      }
    }
  },
  methods: {
    startTyping(){
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
        .post("/save-message", formData, {
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
        .post("/save-message", {
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
            //this.isLoading = false;
            this.$swal({
              title: "خطأ فى الاتصال ",
              type: "error"
            });
          }
        );
    },
    onCancel() { // for loader
      console.log("User cancelled the loader.");
    }
  },
  created() {
    this.allMsgs = this.messages;

    if(this.room){
        var roomUsers = this.room.users;
        if(roomUsers != undefined){
            this.otherRoomUsers = roomUsers.filter((user)=>{
                return user.id != this.user_id;
            });
        }
    }


  },
  mounted: function() {
    console.log("chatComponent mounted");
  }
};
</script>
<style scoped>
  .d-flex {
    display: flex;
    align-items: center;
  }
  .chat-content{
      height: 300px;
      overflow: hidden;
  }
</style>
