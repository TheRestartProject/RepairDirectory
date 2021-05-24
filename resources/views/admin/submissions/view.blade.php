@extends('admin.layout')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between align-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/admin">REPAIR DIRECTORY</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('admin.submissions')</li>
                    </ol>
                </nav>
                <div class="btn-group">
                    <a class="btn btn-primary btn-save" href="{{ route('admin.business.edit') . '/from-submission/' . $submission->getExternalId() }}">Create this business</a>
                </div>
            </div>
        </div>
    </div>

    <h2>@lang('admin.submission'): {{ $submission->getBusinessName() }}</h2> 

    <form action="/admin/submissions/{{ $submission->getExternalId() }}" method="post">
        {{ csrf_field() }}
        <style>
         .col-form-label {
             font-weight: bold;
         }
        </style>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.name')</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ $submission->getBusinessName() }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.website')</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ $submission->getBusinessWebsite() }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.local_area')</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ $submission->getBusinessBorough() }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.review_source')</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ $submission->getReviewSource() }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.submission_date')</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ $submission->getCreatedAt() }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.submitted_by_employee')</label>
            <div class="col-sm-10">
                <input type="text" readonly class="form-control-plaintext" value="{{ $submission->getSubmittedByEmployee() }}">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.submission_extra_info')</label>
            <div class="col-sm-10">
                <textarea readonly class="form-control-plaintext" rows=4>{{ $submission->getExtraInfo() }}</textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.submission_status')</label>
            <div class="col-sm-10">
                <select class='form-control select2 submission-status' name='status' data-external-id="{{ $submission->getExternalId() }}"
                    @if (!$canUpdate)
                        disabled
                    @endif
                >
                    <option value="null">-</option>
                    @foreach ((new ReflectionClass("TheRestartProject\RepairDirectory\Domain\Enums\SubmissionStatus"))->getConstants() as $val)
                        <option value="{{$val}}" {{ ($submission->getStatus() == $val) ? 'selected="selected"' : '' }}">{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 col-form-label">@lang('admin.notes')</label>
            <div class="col-sm-10">
                <textarea
                    name="notes"
                    @if (!$canUpdate)
                    disabled
                    @endif
                    class="form-control-plaintext border" rows=8>{{ $submission->getNotes() }}</textarea>
            </div>
        </div>

        @if ($canUpdate)
        <div class="form-group row">
            <label class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10 offset-">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary btn-save" href="{{ route('admin.submissions.update', $submission->getExternalId()) }}">@lang('admin.save')</button>
                </div>
            </div>
        </div>
        @endif

        <p class="form-text text-muted">Note: links are not automatically clickable, in case malicious data has been submitted.</p>

    </form>

@endsection
