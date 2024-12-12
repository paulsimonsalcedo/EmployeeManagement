<template>
    <div v-if="isModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
        <div class="relative bg-white rounded-lg p-6 w-full sm:w-3/4 md:w-1/2 lg:w-1/3">
            <button class="absolute right-10 top-4  text-gray-800 hover:text-gray-600" @click="closeModal">X</button>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee Details</h2>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        placeholder="Enter name"
                        v-model="form.name"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        placeholder="Enter email"
                        v-model="form.email"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        placeholder="Enter phone number"
                        v-model="form.phone"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Hire Date -->
                <div>
                    <label for="hire-date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                    <input 
                        type="date" 
                        id="hire-date"
                        v-model="form.hire_date"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Salary -->
                <div>
                    <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                    <input 
                        type="number" 
                        id="salary"
                        value="" 
                        placeholder="Enter salary"
                        v-model="form.salary"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit"
                        class="px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
  import { Inertia } from '@inertiajs/inertia';
    export default{
        data(){
            return{
                form:{
                    name: '',
                    email: '',
                    phone: '',
                    hire_date: '',
                    salary: ''
                }
            }
        },
        props:{
            isModalOpen: Boolean,
        },
        methods: {
            closeModal(){
                this.$emit("close");
            },
            submit(){
                Inertia.post('/save-employee', this.form,{
                    onSuccess: () => {
                        // this.$emit('employee-saved');
                        this.closeModal();
                    },
                    onError: (errors) =>{
                        console.log(errors);
                    }
                });
            }
        },
    }
</script>
