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
              <span class="text-gray-300">Email Address</span>
            </th>
            <th class="px-16 py-2">
              <span class="text-gray-300">Posts</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-gray-200">
          <tr class="bg-white border-4 border-gray-200" v-for="user in users" :key="user.id">
            <td class="px-16 py-2 flex flex-row items-center">
              <img
                class="h-8 w-8 rounded-full object-cover "
                :src="user.profile_photo_url"
                alt=""
              />
            </td>
            <td>
              <span class="text-center ml-2 font-semibold">{{ `${user.name} ${user.lastname}` }}</span>
            </td>
            <td class="px-16 py-2">
              <span class="text-center ml-2 font-semibold">{{ user.email }}</span>
            </td>
            <td class="px-16 py-2">
              <span class="text-center ml-2 font-semibold">{{ user.posts.length }}</span>
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
          users:[],
      }
  },

  methods:{
      async getUsers() {
          try {
              const res = await axios.get('/api/v2/users')
              if (res.status === 200) {
                  this.users = res.data

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
      this.getUsers()
  }

}
</script>

<style>

</style>
