@extends('admin.layout')

@section('content')
    <h2>{{ __($isCreate ? 'admin.new_business' : 'admin.edit_business') }}</h2>

    <div class="flash-message">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))

        <p class="alert alert-{{ $msg }} alert-dismissable">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
    </div>

    <form action="{{ $formAction }}" method="post" autocomplete="off">

        <div class="row">

        {{ csrf_field() }}

        {{ method_field($formMethod) }}

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="name">{{ __('admin.name') }}</label>
                <input id="name" name="name" class="form-control validate" value="{{ old('name') ?: $business->getName() }}"/>
                @if($errors->has('name'))
                    <small class="business-error">{{ $errors->first('name') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="address">{{ __('admin.address') }}</label>
                <input id="address" name="address" class="form-control validate"
                       value="{{ old('address') ?: $business->getAddress() }}"/>
                @if($errors->has('address'))
                    <small class="business-error">{{ $errors->first('address') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="city">{{ __('admin.city') }}</label>
                <input id="city" name="city" class="form-control validate" value="{{ old('city') ?: $business->getCity() }}"/>
                @if($errors->has('city'))
                    <small class="business-error">{{ $errors->first('city') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="postcode">{{ __('admin.postcode') }}</label>
                <input id="postcode" name="postcode" class="form-control validate"
                       value="{{ old('postcode') ?: $business->getPostcode() }}"/>
                @if($errors->has('postcode'))
                    <small class="business-error">{{ $errors->first('postcode') }}</small>
                @endif
                @if($errors->has('geolocation'))
                    <small class="business-error">{{ $errors->first('geolocation') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="localAreaAuto">{{ __('admin.local_area') }}</label>
                <input id="localAreaAuto" readonly class="form-control"
                       value="{{ old('localAreaName') ?: $business->getLocalAreaName() }}">
            </div>

            <div class="form-group">
                <label for="description">{{ __('admin.description') }}</label>
                <textarea id="description" name="description"
                          class="form-control validate">{{ old('description') ?: $business->getDescription() }}</textarea>
                @if($errors->has('description'))
                    <small class="business-error">{{ $errors->first('description') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="landline">{{ __('admin.phone') }}</label>
                <input id="landline" name="landline" class="form-control validate"
                       value="{{ old('landline') ?: $business->getLandline() }}">
                @if($errors->has('landline'))
                    <small class="business-error">{{ $errors->first('landline') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="mobile">{{ __('admin.mobile') }}</label>
                <input id="mobile" name="mobile" class="form-control validate"
                       value="{{ old('mobile') ?: $business->getMobile() }}">
                @if($errors->has('mobile'))
                    <small class="business-error">{{ $errors->first('mobile') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="website">{{ __('admin.website') }}</label>
                <input id="website" name="website" class="form-control validate"
                       value="{{ old('website') ?: $business->getWebsite() }}">
                @if($errors->has('website'))
                    <small class="business-error">{{ $errors->first('website') }}</small>
                @elseif($websiteInvalid)
                    <small class="business-error">{{ __('admin.website_invalid') }} {{ $websiteInvalid }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="email">{{ __('admin.email') }}</label>
                <input id="email" name="email" class="form-control validate" value="{{ old('email') ?: $business->getEmail() }}">
                @if($errors->has('email'))
                    <small class="business-error">{{ $errors->first('email') }}</small>
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <label for="categories">{{ __('admin.categories') }}</label>
                <select id="categories" name="categories[]" class="form-control" multiple>
                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                                {{ in_array($category->getValue(), is_array(old('categories[]')) ? old('categories[]') : $business->getCategories()) ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('categories'))
                    <small class="business-error">{{ $errors->first('categories') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="productsRepaired">{{ __('admin.products_repaired') }}</label>
                <input id="productsRepaired" name="productsRepaired" class="form-control" autocomplete="off"
                       value="{{ old('productsRepaired') ?: implode(',', $business->getProductsRepaired()) }}">
                @if($errors->has('productsRepaired'))
                    <small class="business-error">{{ $errors->first('productsRepaired') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="authorisedBrands">{{ __('admin.authorised_brands') }}</label>
                <input id="authorisedBrands" name="authorisedBrands" class="form-control" autocomplete="off"
                       value="{{ old('authorisedBrands') ?: implode(',', $business->getAuthorisedBrands()) }}">
                @if($errors->has('authorisedBrands'))
                    <small class="business-error">{{ $errors->first('authorisedBrands') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="qualifications">{{ __('admin.qualifications') }}</label>
                <textarea id="qualifications" name="qualifications"
                          class="form-control validate">{{ old('qualifications') ?: $business->getQualifications() }}</textarea>
                @if($errors->has('qualifications'))
                    <small class="business-error">{{ $errors->first('qualifications') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="communityEndorsement">{{ __('admin.community_endorsement') }}</label>
                <textarea id="communityEndorsement" name="communityEndorsement"
                          class="form-control validate">{{ old('communityEndorsement') ?: $business->getCommunityEndorsement() }}</textarea>
                @if($errors->has('communityEndorsement'))
                    <small class="business-error">{{ $errors->first('communityEndorsement') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="notes">{{ __('admin.notes') }}</label>
                <textarea id="notes" name="notes"
                          class="form-control validate">{{ old('notes') ?: $business->getNotes() }}</textarea>
                @if($errors->has('notes'))
                    <small class="business-error">{{ $errors->first('notes') }}</small>
                @endif
            </div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="form-group">
                <div class="form-group">
                    <label for="reviewSourceUrl">Review Source URL</label>
                    <div class="input-group">
                        <input id="reviewSourceUrl" name="reviewSourceUrl" class="form-control validate"
                            value="{{ old('reviewSourceUrl') ?: $business->getReviewSourceUrl() }}">
                    </div>
                    @if($errors->has('reviewSourceUrl'))
                        <small class="business-error">{{ $errors->first('reviewSourceUrl') }}</small>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="reviewSource">{{ __('admin.review_source') }}</label>
                <select id="reviewSource" name="reviewSource" class="form-control">
                    @foreach($reviewSources as $source)
                        <option value="{{ $source }}" {{ old('reviewSource') ? (old('reviewSource') == $source ? 'selected' : '') : ($business->getReviewSource() == $source ? 'selected' : '') }}>
                            {{ $source }}
                        </option>
                    @endforeach
                </select>
                @if($errors->has('reviewSource'))
                    <small class="business-error">{{ $errors->first('reviewSource') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="numberOfReviews">{{ __('admin.number_of_reviews') }}</label>
                <input id="numberOfReviews" name="numberOfReviews" class="form-control validate"
                       value="{{ old('numberOfReviews') ?: $business->getNumberOfReviews() }}">
                @if($errors->has('numberOfReviews'))
                    <small class="business-error">{{ $errors->first('numberOfReviews') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="positiveReviewPcRange">{{ __('admin.positive_review_percentage') }}</label>
                <input id="positiveReviewPcRange" name="positiveReviewPcRange" type="range" class="slider" min="0"
                       max="100" value={{ old('positiveReviewPc') ?: $business->getPositiveReviewPc()}}>
                <input id="positiveReviewPc" name="positiveReviewPc" type="number" class="form-control slider-input validate"
                       value={{ old('positiveReviewPc') ?: $business->getPositiveReviewPc()}}>
                <span>%</span>
                @if($errors->has('positiveReviewPc'))
                    <small class="business-error">{{ $errors->first('positiveReviewPc') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="averageScore">{{ __('admin.average_scores') }}</label>
                <input id="averageScore" name="averageScore" class="form-control validate"
                       value="{{ old('averageScore') ?: $business->getAverageScore() }}">
                @if($errors->has('averageScore'))
                    <small class="business-error">{{ $errors->first('averageScore') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="warrantyOffered">{{ __('admin.warranty_offered') }}</label>
                <input type="checkbox" name="warrantyOffered" id="warrantyOffered" class="form-control"
                       {{ old('warrantyOffered') ? (old('warrantyOffered') === 'Yes' ? 'checked' : '') : ($business->isWarrantyOffered() ? 'checked' : '') }} value="Yes">
                @if($errors->has('warrantyOffered'))
                    <small class="business-error">{{ $errors->first('warrantyOffered') }}</small>
                @endif
            </div>

            <div class="form-group">
                <label for="warranty">{{ __('admin.warranty_details') }}</label>
                <textarea name="warranty" id="warranty" cols="30" rows="10"
                          class="form-control validate">{{ old('warranty') ?: $business->getWarranty() }}</textarea>
                @if($errors->has('warranty'))
                    <small class="business-error">{{ $errors->first('warranty') }}</small>
                @endif
            </div>
        </div>
        </div>

        <hr/>

        <div class="row">

            <div class="col-md-4 offset-md-4">
                @if (!$isCreate)
                <div class="row">
                    <div class="col-md-4">
                        Created:
                    </div>
                    <div class="col-md-8">
                        {{ $business->getCreatedAt()->format('d/m/Y H:i:s') }}
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-4">
                            Created by:
                        </div>
                        <div class="col-md-8">
                            @if (!empty($business->getCreatedBy()) && $business->userWhoCreated)
                                {{ $business->userWhoCreated->getName() }}
                            @endif
                        </div>
                    </div>

                <div class="row">
                    <div class="col-md-4">
                        Last updated:
                    </div>
                    <div class="col-md-8">
                        @if (!empty($business->getUpdatedAt()))
                        {{ $business->getUpdatedAt()->format('d/m/Y H:i:s') }}
                        @endif
                    </div>
                </div>

                    <div class="row">
                        <div class="col-md-4">
                            Last updated by:
                        </div>
                        <div class="col-md-8">
                            @if (!empty($business->getUpdatedBy() && $business->userWhoLastUpdated))
                                {{ $business->userWhoLastUpdated->getName() }}
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-4">

                <div class="form-group">

                    <div class="vue">
                        <PublishingStatus
                            :can-update="{{ Auth::user() && Auth::user()->can('update', $business) ? 'true': 'false' }}"
                            value="{{ old('publishingStatus') ?: $business->getPublishingStatus() ?: 'null' }}"
                            :publishing-statuses="{{ json_encode($publishingStatuses, JSON_INVALID_UTF8_IGNORE) }}"
                            hide-value="{{ old('hideReason') ?: $business->getHideReason() ?: 'null' }}"
                            :hide-reasons="{{ json_encode($hideReasons, JSON_INVALID_UTF8_IGNORE) }}"
                        />
                    </div>
                    @if($errors->has('publishingStatus'))
                        <small class="business-error">{{ $errors->first('publishingStatus') }}</small>
                    @endif
                </div>
                @can('update', $business)
                    <div class="clearfix actions">
                        {!! $isCreate ? '' : '<button id="delete" type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-popup">' . __('admin.delete') . '</button>' !!}
                        <button id="submit" class="btn btn-success">{{ __('admin.save') }}</button>
                    </div>
                @endcan
                @if($errors->has('business'))
                    <small class="business-error">{{ $errors->first('business') }}</small>
                @endif
                @if($errors->has('authorization'))
                    <small class="business-error">{{ $errors->first('authorization') }}</small>
                @endif

            </div>
        </div>
    </form>

    <div id="delete-popup" class="modal">
        <div class="modal-dialog"  role="document">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Are you sure you wish to delete this business?</h5>
            </div>
            <div class="modal-footer">
                <form action="/admin/business/{{ $business->getUid() }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}
                    <button id="cancel-delete" class="btn btn-secondary mr-auto" data-dismiss="modal" type="button">{{ __('admin.cancel') }}</button>
                    <button id="confirm-delete" class="btn btn-danger">{{ __('admin.delete') }}</button>
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection
