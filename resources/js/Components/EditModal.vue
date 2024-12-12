<template>
  <div v-if="isEditModalOpen" class="modal-overlay fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
    <div class="modal-content relative bg-white rounded-lg p-6 w-full sm:w-3/4 md:w-1/2 lg:w-1/3">
      <button class="absolute right-10 top-4 text-gray-800 hover:text-gray-600" @click="closeModal">X</button>
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">{{ type === 'employee' ? 'Edit Employee' : 'Edit Department' }}</h2>
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <!-- EDIT EMPLOYEE -->
        <div v-if="type === 'employee'">
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
                placeholder="Enter salary"
                v-model="form.salary"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>

        <!-- EDIT SERVICE-->

        <div v-if="type === 'service'">
              <!-- Department ID -->
              <div>
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department ID</label>
                    <select 
                        id="department_id" 
                        v-model="form.department_id" 
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="" disabled>Select a department</option>
                        <option  v-for="department in departments" :key="department.id" :value="department.id">
                            {{ department.name }}
                        </option>
                    </select>
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <input 
                        type="text" 
                        id="role" 
                        placeholder="Enter role"
                        v-model="form.role"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Performance Notes</label>
                    <input 
                        type="text" 
                        id="notes" 
                        placeholder="Enter Performance Notes"
                        v-model="form.performance_notes"
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div> 
          </div>

          <!-- EDIT DEPARTMENT -->

          <div v-if="type === 'department'">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
              <input 
                    v-model="form.name" 
                    type="text" 
                    id="name"
                    placeholder="Enter Department Name"
                    class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
              />
            </div>
            <div>
              <span class="block text-sm font-medium text-gray-700">Multiline message is:</span>
              <textarea 
                v-model="form.description" 
                id="description"
                placeholder="Enter Description"
                class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               />
            </div>
          </div>

        <!-- Button -->
        <div class="flex justify-end">
          <button 
              class="px-6 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-1" 
              type="submit">
              Update
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

import {Inertia} from '@inertiajs/inertia';
export default {
  props: {
    isEditModalOpen: Boolean,
    type: String, // 'employee' or 'department'
    record: Object,
    departments: Object,
    employeeID: Number,
  },
  data() {
    return {
      form: {},
      errors: {},
    };
  },
  watch: {
    record: {
      immediate: true,
      handler(newRecord) {
        if (newRecord) {
          this.form = { ...newRecord }; // Merge with defaults
        }
      },
    },
  },
  methods: {
    handleSubmit(){
      if (this.type === 'service') {
        this.updateService();
      } else if (this.type === 'employee') {
        this.updateEmployee();
      } else if (this.type === 'department') {
        this.updateDepartment();
      } else {
        console.error('Invalid type:', this.type);
      }
    },
    closeModal() {
      this.$emit('close');
    },
    updateEmployee() {
      Inertia.put(`/update-employee/${this.record.id}`, this.form, {
        onSuccess: () => {
          this.$emit('close'); // Close the modal on success
        },
        onError: (error) => {
          if (error.response && error.response.data && typeof error.response.data === 'object') {
            this.errors = error.response.data;
          } else {
            console.error('Unexpected error:', error);
          }
        },
      });
    },
    updateService(){
      Inertia.put(`/update-service-record/${this.record.id}`,this.form,{
          onSuccess: ()=>{
            this.$emit('close');
          },
          onError: (error)=>{
            console.log(error);
          }
      });
    },
    updateDepartment(){
      Inertia.put(`/update-department/${this.record.id}`, this.form, {
        onSuccess: ()=>{
          this.$emit("close");
        },
        onError: (error)=>{
          console.log(error);
        }
      });
    }
  },
};
</script>
