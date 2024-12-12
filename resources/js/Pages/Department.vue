<template>
    <div class="p-20">
      <h1 class="text-center font-bold text-3xl text-gray-800 mb-4">Department List</h1>
      <button @click="openModal()" class="mb-3 mr-4 bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
            Add New Department
      </button>
      <button @click="backToHome()" class="mb-3 bg-blue-500 text-white px-6 py-2 rounded hover:bg-green-600">
            Back
      </button>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
          <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
              <!-- <th class="py-3 px-6 text-left">#</th> -->
              <th class="py-3 px-6 text-left">Department Name</th>
              <th class="py-3 px-6 text-left">Description</th>
              <th class="py-3 px-6 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
            <tr v-for="department in departments" :key="department.id" class="border-b border-gray-200 hover:bg-gray-100">
              <!-- <td class="py-3 px-6 text-left">{{ index + 1 }}</td> -->
              <td class="py-3 px-6 text-left">{{ department.name }}</td>
              <td class="py-3 px-6 text-left">{{ department.description }}</td>
              <td class="py-3 px-6 text-center">
                <button
                  @click="editModalOpen('department',department)"
                  class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2"
                >
                  Edit
                </button>
                <button
                  @click="deleteDepartment(department.id)"
                  class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                >
                  Delete
                </button>
              </td>
            </tr>
            <tr v-if="departments.length === 0">
              <td colspan="5" class="py-3 px-6 text-center text-gray-500">
                No departments available.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <DepartmentModal
        :isModalOpen="isModalOpen"
        @close="closeModal"
        @fetchDepartments="fetchDepartments"
    />
    
    <EditModal 
      :isEditModalOpen="isEditModalOpen"
      @close="editModalClose"
      type="department"
      :record="currentRecord"
    />
    

  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  import DepartmentModal from '../Components/DepartmentModal.vue';
  import EditModal from '@/Components/EditModal.vue';

  export default {
    components:{
        DepartmentModal,
        EditModal,
    },
    props:{
        departments: Object,
    },
    data(){
        return{
            isModalOpen: false,
            isEditModalOpen: false,
            currentRecord: null,
        }
    },
    methods: {
        editModalOpen(type,record){
          this.isEditModalOpen = true; // open edit Department
          this.currentRecord = record;
        },
        editModalClose(){
          this.isEditModalOpen = false; // close edit Department
          this.currentRecord = null;
        },
        openModal(){ 
            this.isModalOpen = true; //open Add Department
        },
        closeModal(){ 
            this.isModalOpen = false; //close Add Department
        },
        backToHome(){
            Inertia.visit('/welcome');
        },
        fetchDepartments() {
            // Inertia.get('/department', {}, { preserveState: true });
        },
        editDepartment(id){
            console.log(id);
        },
        deleteDepartment(id){
            if(confirm("Are you sure you want to delete this department?")){
                Inertia.delete(`/delete-department/${id}`,{
                    onSuccess: ()=>{
                      
                    },
                    onError: (error)=>{
                        console.log(error);
                    }
                });
            }
        },
    },
  };
  </script>