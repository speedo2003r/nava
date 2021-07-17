<template>
  <div class>
    <p :class="{ online: user.online == 1 }">

        <span v-if="user.online == 1 && Lang == 'ar'"> متصل الان</span>
        <span v-else-if="user.online == 1 && Lang == 'en'"> Connected</span>

        <span v-else-if="user.online == 0 && Lang == 'ar'"> غير متصل</span>
        <span v-else-if="user.online == 0 && Lang == 'en'"> DisConnected</span>

        <span v-else> غير متصل </span>
    </p>
    <!-- <p :class="{ red: user.online == 0 }"><slot></slot></p> -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: "",
      Lang:Lang,
    };
  },
  props: ["user_id"],
  computed: {},
  sockets: {
    isUserConnectedRes(data) {
      //console.log("isUserConnectedRes", data);
      this.user = data.userData[0];
    }
  },
  methods: {},
  created() {
    this.$socket.client.emit("isUserConnected", this.user_id);

    this.$root.$on("newUserConnected", data => {
      this.user.id == data.userId ? (this.user.online = 1) : "";
    });

    this.$root.$on("newUserDisconnect", data => {
      this.user.id == data.userId ? (this.user.online = 0) : "";
    });
  },
  mounted() {

  }
};
</script>
