<template>
  <div>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-2">
          <div class="panel panel-default">
            <div class="panel-heading">Users</div>
            <div class="panel-body" style="padding:0px;">
              <ul class="list-group" style="overflow-y: scroll;height: 400px">
                <li
                  class="list-group-item"
                  v-for="chatList in chatLists"
                  :key="chatList.id"
                  style="cursor: pointer;"
                  @click="chat(chatList)"
                >
                  @{{ chatList.name }}
                  <i
                    class="fa fa-circle pull-left"
                    :class="{'online': (chatList.online==1)}"
                  ></i>
                  <span class="badge" v-if="chatList.msgCount !=0">@{{ chatList.msgCount }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import chatbox from './ChatboxComponent';

export default {
  data() {
    return {
      user_id: USER_ID,
      chatLists: [],
      chatBox: [],
      bArr: {},
    };
  },
  sockets: {
    addMessageResponse(data) {
        if(!this.chatBox.includes(data.user_id)){
            this.chatLists.findIndex(function(el) {
                if(el.id == data.user_id){
                    el.msgCount += 1;
                }
            });
        }
    }
  },
  methods: {
    chat: function(chat) {
      if (!this.chatBox.includes(chat.id)) {
        chat.msgCount = 0;
        const chatboxObj = Vue.extend(chatbox);
        let b = new chatboxObj({
          propsData: {
            otherUser: chat,
            chatBoxClose: this.chatBoxClose,
            chatBoxMinimize: this.chatBoxMinimize
          }
        }).$mount();
        $("body").append(b.$el);
        this.bArr[chat.id] = b;
        this.chatBox.unshift(chat.id);
        $("#msginput-" + chat.id).focus();
      } else {
        var index = this.chatBox.indexOf(chat.id);
        this.chatBox.splice(index, 1);
        this.chatBox.unshift(chat.id);
        $("#msginput-" + chat.id).focus();
      }
      this.calcChatBoxStyle();
    },
    chatBoxClose: function(eleId) {
      $("#chatbox-" + eleId).remove();
      this.$socket.client.emit("leaveRoom", this.bArr[eleId].room.id);
      this.bArr[eleId].$destroy();
      var index = this.chatBox.indexOf(eleId);
      this.chatBox.splice(index, 1);
      this.calcChatBoxStyle();
    },
    chatBoxMinimize: function(eleId) {
      $(
        "#chatbox-" + eleId + " .box-body, #chatbox-" + eleId + " .box-footer"
      ).slideToggle("slow");
    },
    calcChatBoxStyle() {
      var i = 270; // start position
      var j = 260; // next position
      this.chatBox.filter(function(value, key) {
        if (key < 4) {
          $("#chatbox-" + value)
            .css("left", i)
            .show();
          i = i + j;
        } else {
          $("#chatbox-" + value).hide();
        }
      });
    }
  },
  mounted() {
    //console.log("public chat mounted");
  },
  created() {
    this.$http.get("/admin/chats/users").then(
      response => {
        response.body.data.findIndex(function(el) {
          el.msgCount = 0;
        });
        this.chatLists = response.body.data;
      },
      response => {console.log(response);}
    );

    this.$root.$on("newUserConnected", data => {
      this.chatLists.findIndex(function(el) {
          el.id == data.userId ? el.online = 1:"";
        });
    });

    this.$root.$on("newUserDisconnect", data => {
      this.chatLists.findIndex(function(el) {
          el.id == data.userId ? el.online = 0:"";
        });
    });
  }
};
</script>

<style lang="scss" scoped>

</style>



