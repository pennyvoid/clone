<template>
  <div class="flex flex-col items-center" v-if="status.user ==='success' && user && authUser">
    <div class="relative mb-4">
      <div class="w-100 h-64 overflow-hidden">
        <UploadImage
          location="cover"
          imageWidth="1200"
          imageHeight="800"
          :userImage="user.data.attributes.cover_image"
          classes="object-cover w-full"
          alt="backgournd cover image"
        />
        <div class="absolute bottom-0 left-0 -mb-8 z-20 flex items-center ml-12">
          <div class="w-32">
            <UploadImage
              location="profile"
              imageWidth="750"
              imageHeight="750"
              :userImage="user.data.attributes.profile_image"
              classes="w-32 h-32 object-cover rounded-full shadow-lg border-2 border-gray-400"
              alt="backgournd profile image"
            />
          </div>
          <p class="ml-4 text-2xl text-gray-200">{{ user.data.attributes.name}}</p>
        </div>
        <div class="absolute bottom-0 right-0 mb-8 z-20 flex items-center mr-12">
          <button
            v-if="friendButtonText && friendButtonText !== 'Accept'"
            class="py-1 px-3 bg-gray-400 rounded"
            @click="$store.dispatch('sendFriendRequest',$route.params.userId)"
          >{{friendButtonText}}</button>
          <button
            v-if="friendButtonText && friendButtonText === 'Accept'"
            class="py-1 px-3 bg-blue-400 rounded mr-2"
            @click="$store.dispatch('acceptFriendRequest',$route.params.userId)"
          >Accept</button>
          <button
            v-if="friendButtonText && friendButtonText === 'Accept'"
            class="py-1 px-3 bg-gray-400 rounded"
            @click="$store.dispatch('ignoreFriendRequest',$route.params.userId)"
          >Ignore</button>
        </div>
      </div>
    </div>
    <div v-if="status.posts==='loading'">Loading Posts...</div>
    <div v-else-if="!posts">No posts found</div>
    <Post v-else v-for="(post,postKey) in posts.data" :key="postKey" :post="post" class="mt-4" />
  </div>
</template>
<script>
import Post from "../../components/Post";
import UploadImage from "../../components/UploadImage";
import { mapGetters } from "vuex";
export default {
  name: "Show",
  components: {
    Post,
    UploadImage
  },
  mounted() {
    this.$store.dispatch("fetchUser", this.$route.params.userId);
    this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
  },
  computed: {
    ...mapGetters({
      user: "user",
      posts: "posts",
      status: "status",
      friendButtonText: "friendButtonText",
      authUser: "authUser"
    })
  }
};
</script>