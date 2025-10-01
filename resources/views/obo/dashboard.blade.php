@extends('layout.applicant.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Search -->

    <div class="mb-6">
        <input type="text" placeholder="Search Applicant Records" class="border px-4 py-2 rounded w-full md:w-1/3">
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <div class="col-span-1 sm:col-span-2 bg-white p-6 rounded shadow text-center">
            <div class="text-3xl font-bold">2</div>
            <p class="text-gray-600">Apply your building permit</p>
            <div class="mt-5">
                <a href="{{ route('applicant.forms.form') }}" class="mt-10 bg-red-500 text-white py-2 px-4 rounded">+ Add New
                    Building Permit</a>
            </div>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Pending Evaluation</p>
            <div class="text-xl font-bold">5</div>
            <button class="text-blue-500 text-sm mt-2">View</button>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Approved</p>
            <div class="text-xl font-bold">10</div>
            <button class="text-blue-500 text-sm mt-2">View</button>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <p class="text-sm text-gray-500">Disapproved</p>
            <div class="text-xl font-bold">2</div>
            <button class="text-blue-500 text-sm mt-2">View</button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white p-4 rounded shadow overflow-x-auto">
        <div class="flex justify-between items-center mb-2 flex-wrap gap-2">
            <div class="flex flex-wrap gap-2">
                <button class="px-3 py-1 bg-gray-200 rounded">All</button>
                <button class="px-3 py-1 bg-gray-800 text-white rounded">Pending (1)</button>
                <button class="px-3 py-1 bg-gray-200 rounded">Approved (5)</button>
                <button class="px-3 py-1 bg-gray-200 rounded">Disapproved</button>
                <button class="px-3 py-1 bg-gray-200 rounded">Subject for Reconsideration</button>
            </div>
            <span class="text-sm text-gray-500">📅 Today: August 27, 2025</span>
        </div>

        <table class="min-w-full text-sm text-left">
            <thead>
                <tr class="border-b">
                    <th class="px-4 py-2">Application No</th>
                    <th class="px-4 py-2">Project Location</th>
                    <th class="px-4 py-2">Project Reg. Evaluation</th>
                    <th class="px-4 py-2">Evaluations</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">123-45678</td>
                    <td class="px-4 py-2">San Ramon, Lapu</td>
                    <td class="px-4 py-2 text-yellow-500">Pending</td>
                    <td class="px-4 py-2 flex space-x-2">
                        <span class="text-green-500">✔</span>
                        <span class="text-green-500">✔</span>
                        <span class="text-green-500">✔</span>
                    </td>
                    <td class="px-4 py-2">
                        <button class="text-blue-600 hover:underline">View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection
