@extends('admin.layout')

@section('content')
    <h2>{{ __($isCreate ? 'admin.new_business' : 'admin.edit_business') }}</h2>

    <form class="row" action="{{ $formAction }}" method="post">

        {{ csrf_field() }}

        {{ method_field($formMethod) }}

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="name">{{ __('admin.name') }}</label>
                <input id="name" name="name" class="form-control" value="{{ old('name') }}"/>
                @if($errors->has('name'))
                    <small>{{ $errors->first('name') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="address">{{ __('admin.address') }}</label>
                <input id="address" name="address" class="form-control" value="{{ old('address') }}"/>
                @if($errors->has('address'))
                    <small>{{ $errors->first('address') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="city">{{ __('admin.city') }}</label>
                <input id="city" name="city" class="form-control" value="{{ old('city') }}"/>
                @if($errors->has('city'))
                    <small>{{ $errors->first('city') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="postcode">{{ __('admin.postcode') }}</label>
                <input id="postcode" name="postcode" class="form-control" value="{{ old('postcode') }}"/>
                @if($errors->has('postcode'))
                    <small>{{ $errors->first('postcode') }}</small>
                @endif
                @if($errors->has('geolocation'))
                    <small>{{ $errors->first('geolocation') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="localArea">{{ __('admin.local_area') }}</label>
                <input id="localArea" name="localArea" class="form-control" value="{{ old('localArea') }}">
                @if($errors->has('localArea'))
                    <small>{{ $errors->first('localArea') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="description">{{ __('admin.description') }}</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                @if($errors->has('description'))
                    <small>{{ $errors->first('description') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="landline">{{ __('admin.phone') }}</label>
                <input id="landline" name="landline" class="form-control" value="{{ old('landline') }}">
                @if($errors->has('landline'))
                    <small>{{ $errors->first('landline') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="mobile">{{ __('admin.mobile') }}</label>
                <input id="mobile" name="mobile" class="form-control" value="{{ old('mobile') }}">
                @if($errors->has('mobile'))
                    <small>{{ $errors->first('mobile') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="website">{{ __('admin.website') }}</label>
                <input id="website" name="website" class="form-control" value="{{ old('website') }}">
                @if($errors->has('website'))
                    <small>{{ $errors->first('website') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="email">{{ __('admin.email') }}</label>
                <input id="email" name="email" class="form-control" value="{{ old('email') }}">
                @if($errors->has('email'))
                    <small>{{ $errors->first('email') }}</small>
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="categories">{{ __('admin.categories') }}</label>
                <select id="categories" name="categories[]" class="form-control" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                                {{ in_array($category->getValue(), is_array(old('categories[]')) ? old('categories[]') : []) ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <small>{{ $errors->first('categories') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="productsRepaired">{{ __('admin.products_repaired') }}</label>
                <input id="productsRepaired" name="productsRepaired" class="form-control"
                       value="{{ old('productsRepaired') }}">
                @if($errors->has('productsRepaired'))
                    <small>{{ $errors->first('productsRepaired') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="authorisedBrands">{{ __('admin.authorised_brands') }}</label>
                <input id="authorisedBrands" name="authorisedBrands" class="form-control"
                       value="{{ old('authorisedBrands') }}">
                @if($errors->has('authorisedBrands'))
                    <small>{{ $errors->first('authorisedBrands') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="qualifications">{{ __('admin.qualifications') }}</label>
                <textarea id="qualifications" name="qualifications" class="form-control">{{ old('qualifications') }}</textarea>
                @if($errors->has('qualifications'))
                    <small>{{ $errors->first('qualifications') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="communityEndorsement">{{ __('admin.community_endorsement') }}</label>
                <textarea id="communityEndorsement" name="communityEndorsement" class="form-control">{{ old('communityEndorsement') }}</textarea>
                @if($errors->has('communityEndorsement'))
                    <small>{{ $errors->first('communityEndorsement') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="notes">{{ __('admin.notes') }}</label>
                <textarea id="notes" name="notes" class="form-control">{{ old('notes') }}</textarea>
                @if($errors->has('notes'))
                    <small>{{ $errors->first('notes') }}</small>
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="positiveReviewPcRange">{{ __('admin.positive_review_percentage') }}</label>
                <input id="positiveReviewPcRange" name="positiveReviewPcRange" type="range" class="slider" min="0" max="100" value={{ old('positiveReviewPcRange') }}>
                <input id="positiveReviewPc" name="positiveReviewPc" type="number" class="form-control slider-input" value={{ old('positiveReviewPcRange') }}>
                <span>%</span>
                @if($errors->has('positiveReviewPc'))
                    <small>{{ $errors->first('positiveReviewPc') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="reviewSource">{{ __('admin.review_source') }}</label>
                <select id="reviewSource" name="reviewSource" class="form-control">
                    @foreach($reviewSources as $source)
                        <option value="{{ $source }}" {{ old('reviewSource') == $source ? 'selected' : '' }}>
                            {{ $source }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('reviewSource'))
                    <small>{{ $errors->first('reviewSource') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="reviewSourceUrl">Review Source URL</label>
                <input id="reviewSourceUrl" name="reviewSourceUrl" class="form-control" value="">
                {!! array_key_exists('reviewSourceUrl', $errors) ? '<small>' . $errors['reviewSourceUrl'] . '</small>' : '' !!}
            </div>

            <div class="form-group">
                <label for="numberOfReviews">{{ __('admin.number_of_reviews') }}</label>
                <input id="numberOfReviews" name="numberOfReviews" class="form-control" value="{{ old('numberOfReviews') }}">
                @if($errors->has('numberOfReviews'))
                    <small>{{ $errors->first('numberOfReviews') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="averageScore">{{ __('admin.average_scores') }}</label>
                <input id="averageScore" name="averageScore" class="form-control" value="{{ old('averageScore') }}">
                @if($errors->has('averageScore'))
                    <small>{{ $errors->first('averageScore') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="warrantyOffered">{{ __('admin.warranty_offered') }}</label>
                <input type="checkbox" name="warrantyOffered" id="warrantyOffered" class="form-control" {{ old('warrantyOffered') === 'Yes' ? 'checked' : ''}} value="Yes" >
                @if($errors->has('warrantyOffered'))
                    <small>{{ $errors->first('warrantyOffered') }}</small>
                @endif
            </div>
            
            <div class="form-group">
                <label for="warranty">{{ __('admin.warranty_details') }}</label>
                <textarea name="warranty" id="warranty" cols="30" rows="10" class="form-control">{{ old('warranty') }}</textarea>
                @if($errors->has('warranty'))
                    <small>{{ $errors->first('warranty') }}</small>
                @endif
            </div>

            <div class="form-group">

                <label for="publishingStatus">{{ __('admin.publishing_status') }}</label>
                @can('update', $business)
                <select id="publishingStatus" name="publishingStatus" class="form-control">
                    @foreach($publishingStatuses as $status)
                        @if(in_array($status, $authorizedStatuses, false))
                        <option value="{{ $status }}"
                                {{ old('publishingStatus') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                        @endif
                    @endforeach
                </select>
                @else
                    <input id="publishingStatus" name="publishingStatus" class="form-control" readonly value="{{ old('publishingStatus') }}"/>
                @endcan
                @if($errors->has('publishingStatus'))
                    <small>{{ $errors->first('publishingStatus') }}</small>
                @endif
            </div>

            @can('update', $business)
            <div>
                <button id="submit" class="btn btn-success">{{ __('admin.save') }}</button>
            </div>
            @endcan
            @if($errors->has('business'))
                <small>{{ $errors->first('business') }}</small>
            @endif
            @if($errors->has('authorization'))
                <small>{{ $errors->first('authorization') }}</small>
            @endif
        </div>
    </form>
@endsection