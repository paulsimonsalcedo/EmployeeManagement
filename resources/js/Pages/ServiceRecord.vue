<template>
  <div class="p-20">
    <h1 class="text-center font-bold text-3xl text-gray-800 mb-4">Service Records List</h1>
    <button @click="addServiceRecord()" class="mb-3 mr-4 bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
          Add New Service
    </button>
    <button @click="backToHome()" class="mb-3 bg-blue-500 text-white px-6 py-2 rounded hover:bg-green-600">
          Back
    </button>
    <div class="overflow-x-auto">
      <table class="min-w-full bg-white border border-gray-200 shadow-md rounded">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
          <tr>
            <!-- <th class="py-3 px-6 text-left">#</th> -->
            <th class="py-3 px-6 text-left">Employee Name</th>
            <th class="py-3 px-6 text-left">Department</th>
            <th class="py-3 px-6 text-left">Role</th>
            <th class="py-3 px-6 text-center">Performance Notes</th>
            <th class="py-3 px-6 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
          <tr v-for="serviceRecord in serviceRecords " :key="serviceRecord.id" class="border-b border-gray-200 hover:bg-gray-100">
            <!-- <td class="py-3 px-6 text-left">{{ index + 1 }}</td> -->
            <td class="py-3 px-6 text-left">{{ serviceRecord.employee.name }}</td>
            <td class="py-3 px-6 text-left">{{ serviceRecord.department.name }}</td>
            <td class="py-3 px-6 text-left">{{ serviceRecord.role }}</td>
            <td class="py-3 px-6 text-left">{{ serviceRecord.performance_notes }}</td>
            <td class="py-3 px-6 text-center">
              <button
                @click="editModalOpen('department', serviceRecord)"
                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2"
              >
                Edit
              </button>
              <button
                @click="deleteService(serviceRecord.id)"
                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
              >
                Delete
              </button>
            </td>
          </tr>
          <tr v-if="serviceRecords.length === 0">
            <td colspan="5" class="py-3 px-6 text-center text-gray-500">
              No Service Records available.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <ServiceRecordModal 
      :isModalOpen="isModalOpen"
      @close="closeModal"
      :departments="departments"
      :employeeID="parseInt(employeeID)"
      :resetForm="resetForm"
  />

  <EditModal
    :isEditModalOpen = "isEditModalOpen"
    @close="editModalClose"
    type="service"
    :record = "datas"
    :employeeID = "employeeID"
    :departments ="departments"
  />

</template>

<script>

  import { Inertia } from '@inertiajs/inertia';
  import ServiceRecordModal from '@/Components/ServiceRecordModal.vue';
  import EditModal from '@/Components/EditModal.vue';

  export default{
      components: {
          ServiceRecordModal,
          EditModal,
      },  
      props:{
          serviceRecords: Object,
          employeeID: Number,
          departments: Object,
      },
      data(){
          return{
              isModalOpen: false,
              isEditModalOpen: false,
              type: '',
              datas: null,
          }
      },
      methods:{
          backToHome(){
              Inertia.visit('/welcome');
          },
          addServiceRecord(){
              this.isModalOpen = true;
          },
          closeModal(){
              this.isModalOpen = false;
              this.resetForm();
          },
          deleteService(id){
              if(confirm("Are you sure you want to delete this?")){
                  Inertia.delete(`/delete-service/${id}`);
              }
          },
          editModalOpen(type, datas){
              this.type = type;
              this.datas = datas;
              this.isEditModalOpen = true;
          },
          editModalClose(){
            this.isEditModalOpen = false;
          },
          resetForm() {
          // Define the resetForm method here
            this.form = {
              employee_id: this.employeeID,
              department_id: '',
              role: '',
              performance_notes: ''
            };
          },
        }
  }
</script>