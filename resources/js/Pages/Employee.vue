

<template>

    <div class="nav flex items-center justify-between bg-gray-100 px-4 py-3 shadow">
        <!-- Left: Title -->
        <h1 class="font-bold text-xl text-gray-800">Employee Management</h1>
        
        <!-- Center: Search Bar -->
        <div class="flex-grow mx-4">
            <input 
                type="text"
                @input="searchEmployees"
                v-model="filters.search" 
                placeholder="Search..." 
                class="w-full max-w-md px-4 py-2 text-gray-700 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
            />
        </div>
        
        <!-- Right: Buttons -->
        <div class="flex space-x-4">
            <button @click="openModal()" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                Add New Employee
            </button>
            <button @click="goToRecords()" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                View Records
            </button>
            <button @click="goToDepartments()" class="bg-purple-500 text-white px-6 py-2 rounded hover:bg-purple-600">
                View Departments
            </button>
            <button @click="logout()" class="flex items-center space-x-2 bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                <span class="material-icons">logout</span>
                <span>Logout</span>
            </button>
        </div>
    </div>

    <div class="p-10">
        
        <div class="flex flex-wrap justify-center gap-4 p-4">
            <!-- If No Data -->
            <div
                v-if="employees.data.length === 0"
                class="p-6 bg-gray-200 rounded-lg text-center text-gray-600"
            >
                No Data Available
            </div>
            <!-- Display Employee Cards -->
            <div
                v-for="employee in employees.data"
                :key="employee.id"
                @click.stop="serviceRecord(employee.id)"
                class="cursor-pointer bg-white rounded-lg shadow-lg p-6 w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
            >
                <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ employee.name }}</h2>
                <p class="text-sm text-gray-600"><strong>Email:</strong> {{ employee.email }}</p>
                <p class="text-sm text-gray-600"><strong>Phone:</strong> {{ employee.phone }}</p>
                <p class="text-sm text-gray-600"><strong>Hire Date:</strong> {{ employee.hire_date }}</p>
                <p class="text-sm text-gray-600"><strong>Salary:</strong> ${{ employee.salary }}</p>
                <p v-if="employee.department && employee.department !== 'N/A'" class="text-sm text-gray-600">
                    <strong>Department:</strong> {{ employee.department }}
                </p>
                <p v-else class="text-sm text-red-600">No Department Assigned</p>

                <span 
                    class="material-icons mt-5 mr-2 text-[20px] text-blue-500 cursor-pointer hover:text-[25px] transition-all duration-200" 
                    @click.stop="editModalOpen('employee', employee)">
                    edit
                </span>
                <span 
                    class="material-icons mt-5 mr-2 text-[20px] text-red-500 cursor-pointer hover:text-[25px] transition-all duration-200" 
                    @click.stop="deleteEmployee(employee.id)">
                    delete
                </span>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="employees.links.length" class="mt-6 flex justify-center space-x-2">
            <button
                v-for="(link, index) in employees.links"
                :key="index"
                :disabled="!link.url"
                @click="fetchPage(link.url)"
                class="px-3 py-1 border rounded hover:bg-gray-200"
                :class="{ 'bg-blue-500 text-white': link.active, 'text-gray-600': !link.active }"
            >
                <span v-html="link.label"></span>
            </button>
        </div>

        <!-- ADD Employee Details Modal -->
        <EmployeeModal 
            :isModalOpen="isModalOpen"  
            @close="closeModal"
            @employee-saved="fetchEmployees"
        />

        <!-- EDIT Employee Details Modal -->
        <EditModal 
            :isEditModalOpen = "isEditModalOpen"
            :record = "record"
            @close = "editModalClose"
            type="employee"
        />
    </div>
</template>

<script>


import { Inertia } from '@inertiajs/inertia';
import EmployeeModal from '../Components/EmloyeeModal.vue';
import EditModal from '@/Components/EditModal.vue';

export default {
    components: {
        EmployeeModal,
        EditModal,
    },
    props: {
        employees: Object,
    },
    data() {
        return {
            isModalOpen: false,
            filters: {
                search: this.employees.filters?.search || '',
            },
            isEditModalOpen: false,
            record: null,
        };
    },
    methods: {
        openModal() {
            this.isModalOpen = true; //Open Add Employee
        },
        closeModal() {
            this.isModalOpen = false; // Close Add Employee
        },
        fetchEmployees() {
            Inertia.get('/dashboard', this.filters, { preserveState: true });
        },
        searchEmployees() {
            this.fetchEmployees(); // Automatically updates the list as the user types
        },
        fetchPage(url) {
            Inertia.visit(url, { preserveState: true, preserveScroll: true });
        },
        goToDepartments() {
            Inertia.visit('/department');
        },
        editModalOpen(type,record){
            this.record = record;
            this.isEditModalOpen = true;
        },
        editModalClose(){
            this.isEditModalOpen = false;
        },
        deleteEmployee(id){
            if(confirm("Are you sure you want to delete this Employee?"))
            {
                    Inertia.delete(`/delete-employee/${id}`,{
                    onSuccess: ()=>{
                        
                    },
                    onError: ()=>{
                        console.log(error);
                    }
                });
            }
        },
        serviceRecord(id){
            Inertia.get('/serviceRecord', { id });
        },
        goToRecords(){
            Inertia.visit('/all-records');
        },
        logout(){
            Inertia.post('/logout', {},{
                onSuccess: ()=>{
                    console.log('Logged out successfully.');
                },
                onError: ()=>{
                    console.log('Logged out successfully.');
                }
            });
        },
    },
};
</script>