<template>
  <div>
    <img :src="userImage.data.attributes.path" :alt="alt" :class="classes" ref="userImage" />
  </div>
</template>

<script>
import Dropzone from "dropzone";
import { mapGetters } from "vuex";
export default {
  name: "UploadImage",
  props: [
    "location",
    "imageWidth",
    "imageHeight",
    "userImage",
    "classes",
    "alt"
  ],
  data() {
    return {
      dropzone: null,
      uploadedImage: null
    };
  },
  mounted() {
    if (this.authUser.data.user_id.toString() === this.$route.params.userId) {
      this.dropzone = new Dropzone(this.$refs.userImage, this.setting);
    }
  },
  computed: {
    ...mapGetters({
      authUser: "authUser"
    }),
    setting() {
      return {
        paramName: "image",
        url: "/api/user-images",
        acceptedFiles: "image/*",
        params: {
          width: this.imageWidth,
          height: this.imageHeight,
          location: this.location
        },
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector("meta[name=csrf-token]")
            .content
        },
        success(event, response) {
          this.$store.dispatch("fetchAuthUser");
          this.$store.dispatch("fetchUser", this.$route.params.userId);
          this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
        }
      };
    }
  }
};
</script>