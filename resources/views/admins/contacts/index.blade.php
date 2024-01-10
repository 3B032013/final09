@extends('admins.layouts.master')

@section('page-title', '意見回饋')

@section('page-content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">意見回饋</h1>
        <table class="table">
            <thead>
            <tr>
                <th scope="col" style="text-align:left">#</th>
                <th scope="col" style="text-align:left">姓名</th>
                <th scope="col" style="text-align:left">電話</th>
                <th scope="col" style="text-align:left">信箱</th>
                <th scope="col" style="text-align:left">標題</th>
                <th scope="col" style="text-align:center">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $index => $contact)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->title }}</td>
                    <td style="text-align:center">
                        <a href="{{ route('admins.contacts.show',$contact->id) }}" class="btn btn-secondary btn-sm">檢視</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <div class="d-flex align-items-center">
                <span class="mr-1">每</span>
                <select id="records-per-page" class="form-control" onchange="changeRecordsPerPage()">
                    <option value="5" {{ $contacts->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $contacts->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $contacts->perPage() == 20 ? 'selected' : '' }}>20</option>
                </select>
                <span class="ml-1">筆</span>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            @if ($contacts->currentPage() > 1)
                <a href="{{ $contacts->previousPageUrl() }}" class="btn btn-secondary">上一頁</a>
            @endif

            <span class="mx-2">全部 {{ $contacts->total() }} 筆資料，目前位於第 {{ $contacts->currentPage() }} 頁，共 {{ $contacts->lastPage() }} 頁</span>

            @if ($contacts->hasMorePages())
                <a href="{{ $contacts->nextPageUrl() }}" class="btn btn-secondary">下一頁</a>
            @endif
        </div>
    </div>
    <script>
        function changeRecordsPerPage() {
            const select = document.getElementById('records-per-page');
            const value = select.options[select.selectedIndex].value;
            window.location.href = `{{ route('admins.contacts.index') }}?perPage=${value}`;
        }
    </script>
@endsection
