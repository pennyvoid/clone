<template>
  <div class="bg-white h-12 flex px-4 items-center border-b border-gray-400 shadow" v-if="authUser">
    <div class="w-1/3">
      <div class="flex">
        <router-link to="/">
          <svg xmlns="http://www.w3.org/2000/svg" class="fill-current w-8 h-8" viewBox="0 0 32 32">
            <path
              d="M21.164 5.074c-1.984 0-2.548.88-2.548 2.82v3.202h5.277l-.52 5.187h-4.758V32H12.3V16.282H8.04v-5.187h4.262V7.983C12.302 2.75 14.4 0 20.285 0c1.263 0 2.774.1 3.676.226v4.87"
              fill="#3c5a99"
            />
          </svg>
        </router-link>
        <div class="ml-2 relative flex items-center">
          <div class="absolute text-gray-700 hover:text-blue-800">
            <svg viewBox="0 0 24 24" class="fill-current w-6 h-6 ml-2">
              <path
                fill-rule="evenodd"
                d="M20.2 18.1l-1.4 1.3-5.5-5.2 1.4-1.3 5.5 5.2zM7.5 12c-2.7 0-4.9-2.1-4.9-4.6s2.2-4.6 4.9-4.6 4.9 2.1 4.9 4.6S10.2 12 7.5 12zM7.5.8C3.7.8.7 3.7.7 7.3s3.1 6.5 6.8 6.5c3.8 0 6.8-2.9 6.8-6.5S11.3.8 7.5.8z"
                clip-rule="evenodd"
              />
            </svg>
          </div>

          <input
            type="text"
            name="searcg"
            class="rounded-full w-56 bg-gray-200 h-8 focus:outline-none focus:shadow-outline text-sm pl-8"
            placeholder="Search Facebook"
          />
        </div>
      </div>
    </div>
    <div class="w-1/3 flex justify-center items-center h-full">
      <router-link to="/" class="mx-6 px-4 border-b-2 border-blue-600 h-full flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-6 h-6">
          <path
            d="M22.6 11l-9.9-9c-.4-.4-1.1-.4-1.5 0l-9.9 9c-.3.3-.5.8-.3 1.2.2.5.6.8 1.1.8h1.6v9c0 .4.3.6.6.6h5.4c.4 0 .6-.3.6-.6v-5.5h3.2V22c0 .4.3.6.6.6h5.4c.4 0 .6-.3.6-.6v-9h1.6c.5 0 .9-.3 1.1-.7.3-.5.2-1-.2-1.3zm-2.5-8h-4.3l5 4.5V3.6c0-.3-.3-.6-.7-.6z"
          />
        </svg>
      </router-link>

      <router-link
        :to="'/users/' + authUser.data.user_id"
        class="mx-6 px-2 h-full flex items-center border-b-2 border-white"
      >
        <img
          :src="authUser.data.attributes.profile_image.data.attributes.path"
          class="w-8 h-8 object-cover rounded-full"
          alt="backgournd profile image"
        />
      </router-link>
      <router-link to="/" class="mx-6 px-2 h-full flex items-center border-b-2 border-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-6 h-6">
          <path
            d="M.5 11.6c0 3.4 1.7 6.3 4.3 8.3V24l3.9-2.1c1 .3 2.2.4 3.3.4 6.4 0 11.5-4.8 11.5-10.7C23.5 5.8 18.3 1 12 1S.5 5.8.5 11.6zm10.3-2.9l3 3.1 5.6-3.1-6.3 6.7-2.9-3.1-5.7 3.1 6.3-6.7z"
          />
        </svg>
      </router-link>
    </div>
    <div class="w-1/3 flex justify-end mr-2">
      <router-link to="/">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="fill-current w-6 h-6">
          <path
            d="M22.9 10.1c-.1-.1-.2-.2-.3-.2L20 9.5c-.1-.5-.3-.9-.6-1.4.2-.2.4-.6.8-1 .3-.4.6-.8.7-1 .1 0 .1-.2.1-.3 0-.1 0-.2-.1-.3-.3-.5-1.1-1.3-2.4-2.4-.1-.1-.2-.1-.4-.1-.1 0-.3 0-.3.1l-2 1.5c-.4-.2-.8-.4-1.3-.5l-.4-2.6c0-.1-.1-.2-.2-.3-.1-.2-.2-.2-.3-.2h-3.2c-.3 0-.4.1-.5.4-.1.5-.3 1.4-.4 2.7-.5.1-.9.3-1.3.5l-2-1.5c-.1-.1-.3-.2-.4-.2-.2 0-.7.3-1.4 1-.6.7-1.1 1.3-1.4 1.6-.1.1-.1.2-.1.3 0 .1 0 .2.1.3.6.8 1.2 1.4 1.5 2-.2.5-.3.9-.5 1.4l-2.6.4c-.1 0-.2.1-.3.2-.1.1-.1.2-.1.3v3.2c0 .1 0 .2.1.3.1.1.2.2.3.2l2.6.4c.1.5.3.9.6 1.4-.2.2-.4.6-.8 1-.3.4-.6.8-.7 1-.1.1-.1.2-.1.3 0 .1 0 .2.1.3.4.5 1.2 1.3 2.4 2.4.1.1.2.2.4.2.1 0 .3 0 .4-.1l2-1.5c.3.1.7.3 1.2.5l.4 2.6c0 .1.1.2.2.3.1.1.2.1.4.1h3.2c.3 0 .4-.1.5-.4.1-.5.3-1.4.4-2.7.4-.1.9-.3 1.3-.5l2 1.5c.1.1.3.1.4.1.2 0 .7-.3 1.3-1 .7-.7 1.2-1.2 1.4-1.5.1-.1.1-.2.1-.3 0-.1 0-.2-.1-.4-.7-.8-1.2-1.5-1.5-2 .2-.4.4-.8.6-1.3l2.7-.4c.1 0 .2-.1.3-.2.1-.1.1-.2.1-.3v-3.2c-.2-.1-.2-.2-.3-.3zm-8.3 4.5c-.7.7-1.6 1.1-2.6 1.1s-1.9-.4-2.6-1.1c-.7-.7-1.1-1.6-1.1-2.6s.4-1.9 1.1-2.6c.7-.7 1.6-1.1 2.6-1.1s1.9.4 2.6 1.1c.7.7 1.1 1.6 1.1 2.6s-.4 1.9-1.1 2.6z"
          />
        </svg>
      </router-link>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "Nav",
  computed: {
    ...mapGetters({
      authUser: "authUser"
    })
  }
};
</script>
