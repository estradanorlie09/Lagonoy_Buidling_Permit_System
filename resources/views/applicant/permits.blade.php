@extends('layout.applicant.app')

@section('title', 'Permits')

@section('content')
    <h1 class="text-2xl font-bold text-red-500 mb-3">Permits</h1>

    <a href="{{ route('applicant.forms.form') }}">

        <div class="w-40 h-40 border border-red-400 mt-5 rounded">
            <div class="flex justify-center items-center">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 text-center">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>

                    <h1 class="text-md font-bold text-red-500 ">Add Projects</h1>
                </div>
            </div>
        </div>
    </a>
@endsection
