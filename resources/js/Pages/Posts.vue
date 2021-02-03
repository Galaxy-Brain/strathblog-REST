<template>
  <app-layout>
      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
      </template>
      <div class="py-9">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!-- component -->
<div>
      <table class="min-w-full table-auto">
        <thead class="justify-between">
          <tr class="bg-gray-800">
            <th class="px-16 py-2">
              <span class="text-gray-300">User Image</span>
            </th>
            <th class="px-16 py-2">
              <span class="text-gray-300">User Name</span>
            </th>
            <th class="px-16 py-2">
              <span class="text-gray-300">Posts Title</span>
            </th>
            <th class="px-16 py-2">
              <span class="text-gray-300">Post Description</span>
            </th>

            <th class="px-16 py-2">
              <span class="text-gray-300">Date Created</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-gray-200">
          <tr class="bg-white border-4 border-gray-200" v-for="post in posts" :key="post.id">
            <td class="px-16 py-2 flex flex-row items-center">
              <img
                class="h-8 w-8 rounded-full object-cover "
                :src="post.user.profile_photo_url"
                alt=""
              />
            </td>
            <td>
              <span class="text-center ml-2 font-semibold">{{ `${post.user.name} ${post.user.lastname}` }}</span>
            </td>
            <td class="px-16 py-2">
              <span class="text-center ml-2 font-semibold">{{ post.title }}</span>
            </td>
            <td class="px-16 py-2">
              <span class="text-center ml-2 font-semibold">{{ post.desc }}</span>
            </td>
            <td class="px-16 py-2">
              <span>{{ new Date(post.created_at)}}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
                </div>
            </div>
        </div>
  </app-layout>
</template>

<script>
import AppLayout from '../Layouts/AppLayout.vue'
export default {
  components: { AppLayout },
  data(){
      return{
          posts:[],
      }
  },

  methods:{
      async getPosts() {
          try {
              const res = await axios.get('/api/v2/posts')
              if (res.status === 200) {
                  this.posts = res.data.posts

              }else{
                  return Toast.fire({
                      icon: 'info',
                      title: 'Hmmm...',
                      text: 'You seem to not be able to do shit'
                  })
              }
          } catch (err) {
              return Toast.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: err.message
                })
          }
      }
  },
  created(){
      this.getPosts()
  }

}
</script>

<style>

</style>
