<template>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
      <div class="w-full max-w-md bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Login</h1>
        <form @submit.prevent="submit">
          <!-- Email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
  
          <!-- Password -->
          <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input
              id="password"
              v-model="form.password"
              type="password"
              required
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
  
          <!-- Remember Me -->
          <div class="mb-4">
            <label class="flex items-center">
              <input
                type="checkbox"
                v-model="form.remember"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
              />
              <span class="ml-2 text-sm text-gray-700">Remember me</span>
            </label>
          </div>
  
          <!-- Submit -->
          <div class="flex justify-end">
            <button
              type="submit"
              class="px-4 py-2 bg-indigo-600 text-white rounded shadow hover:bg-indigo-700"
            >
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import { useForm } from "@inertiajs/inertia-vue3";
  import { Inertia } from '@inertiajs/inertia';
  export default {
    props: {
    isAuthenticated: Boolean,
    },
    mounted() {
      if (this.isAuthenticated) {
        window.location.href = '/welcome';
      }
    },
    data() {
      return{
        form:{
          email: '',
          password: '',
          remember: false
        }
      }
    },
    methods:{
      submit(){
        Inertia.post('/login', this.form,{
          onSuccess: (result)=>{
            console.log(result);
          },
          onError: (errors) =>{
            console.log(errors);
          }
        });
      }
    }
  };
  </script>
  