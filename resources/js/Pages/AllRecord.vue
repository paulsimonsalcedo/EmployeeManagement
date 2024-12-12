<template>
    <div class="p-20">
      <h1 class="text-center font-bold text-3xl text-gray-800 mb-4">Service Records List</h1>
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
            </tr>
          </thead>
          <tbody class="text-gray-600 text-sm font-light">
            <tr v-for="serviceRecord in allService " :key="serviceRecord.id" class="border-b border-gray-200 hover:bg-gray-100">
              <!-- <td class="py-3 px-6 text-left">{{ index + 1 }}</td> -->
              <td class="py-3 px-6 text-left">{{ serviceRecord.employee.name }}</td>
              <td class="py-3 px-6 text-left">{{ serviceRecord.department.name }}</td>
              <td class="py-3 px-6 text-left">{{ serviceRecord.role }}</td>
              <td class="py-3 px-6 text-left">{{ serviceRecord.performance_notes }}</td>
            </tr>
            <tr v-if="allService.length === 0">
              <td colspan="5" class="py-3 px-6 text-center text-gray-500">
                No Service Records available.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
</template>

<script>

import {Inertia} from '@inertiajs/inertia';

    export default{
        props:{
            allService: Object,
        },
        methods:{
            backToHome(){
                Inertia.visit('/welcome');
            }
        }

    }
</script>