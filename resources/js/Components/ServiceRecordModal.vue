<template>
    <div v-if="isModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center">
      <div class="relative bg-white rounded-lg p-6 w-full sm:w-3/4 md:w-1/2 lg:w-1/3">
        <button class="absolute right-10 top-4 text-gray-800 hover:text-gray-600" @click="closeModal">X</button>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Employee Details</h2>
        <form @submit.prevent="submit" class="space-y-4">
          <!-- Department ID -->
          <div>
            <label for="department_id" class="block text-sm font-medium text-gray-700">Department ID</label>
            <select 
              id="department_id" 
              v-model="form.department_id" 
              class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="" disabled>Select a department</option>
              <option v-for="department in departments" :key="department.id" :value="department.id">
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
  
  export default {
    data() {
      return {
        form: {
          employee_id: '',
          department_id: '',
          role: '',
          performance_notes: '',
        }
      };
    },
    props: {
      departments: Object,
      isModalOpen: Boolean,
      employeeID: {
        type: Number,
        required: true,
    },
    },
    methods: {
      closeModal() {
        this.resetForm(); 
        this.$emit("close");
      },
      submit() {

        Inertia.post(`/save-serviceRecords/${this.employeeID}`, {
            employee_id: this.form.employee_id, 
            department_id: this.form.department_id,
            role: this.form.role,
            performance_notes: this.form.performance_notes,
        }, {
            onSuccess: () => {
                this.closeModal(); // Close modal upon successful submission.
            },
            onError: (error) => {
                console.error(error); // Log errors to debug.
            }
        });
      },
      resetForm() {
        this.form = {
          employee_id: this.employeeID,
          department_id: '',
          role: '',
          performance_notes: ''
        };
      }
    }
  }
  </script>
