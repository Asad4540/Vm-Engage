@extends('layouts.app')
@section('pageTitle', 'Ad-Campaign')
@section('content')


    <div class="container mt-5">
        <div class="row">
            <div class="col-3">
                <div class="nav flex-column nav-pillsec" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="tab1-tab" data-bs-toggle="pill" data-bs-target="#tab1" type="button"
                        role="tab" aria-controls="tab1" aria-selected="true">Edit Campaign</button>

                    <button class="nav-link" id="tab2-tab" data-bs-toggle="pill" data-bs-target="#tab2" type="button"
                        role="tab" aria-controls="tab2" aria-selected="false">Your Ads Placed on Pages</button>
                    <button class="nav-link" id="tab3-tab" data-bs-toggle="pill" data-bs-target="#tab3" type="button"
                        role="tab" aria-controls="tab3" aria-selected="false">Pacing</button>
                    <button class="nav-link" id="tab4-tab" data-bs-toggle="pill" data-bs-target="#tab4" type="button"
                        role="tab" aria-controls="tab4" aria-selected="false">Clicks & Impressions</button>
                    <button class="nav-link" id="tab5-tab" data-bs-toggle="pill" data-bs-target="#tab5" type="button"
                        role="tab" aria-controls="tab5" aria-selected="false">Devices</button>
                    <button class="nav-link" id="tab6-tab" data-bs-toggle="pill" data-bs-target="#tab6" type="button"
                        role="tab" aria-controls="tab6" aria-selected="false">User by Region</button>
                    <button class="nav-link" id="tab7-tab" data-bs-toggle="pill" data-bs-target="#tab7" type="button"
                        role="tab" aria-controls="tab8" aria-selected="false">Multiple Ads</button>
                    <button class="nav-link" id="tab8-tab" data-bs-toggle="pill" data-bs-target="#tab8" type="button"
                        role="tab" aria-controls="tab8" aria-selected="false">Top Sites</button>
                </div>
            </div>

            <div class="col-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                        <div class="container">
                            <h2>Edit Campaign</h2><br><br>

                            <form action="{{ url('/ad-campaign/' . $campaign->id . '/update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Client   -->
                                <div class="mb-3">
                                    <label for="client_id" class="form-label fw-semibold">Select Client</label>
                                    <select name="client_id" id="client_id" class="form-control" required>
                                        <option value="" disabled>--Select--</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $campaign->client_id == $client->id ? 'selected' : '' }}>{{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status  -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="active" {{ $campaign->status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="pending" {{ $campaign->status == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="paused" {{ $campaign->status == 'paused' ? 'selected' : '' }}>Paused
                                        </option>
                                        <option value="completed" {{ $campaign->status == 'completed' ? 'selected' : '' }}>
                                            Completed</option>
                                    </select>
                                </div>

                                <!-- Ad Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Ad Name</label>
                                    <input type="text" name="ad_name" value="{{ old('ad_name', $campaign->ad_name) }}"
                                        class="form-control">
                                </div>

                                <!-- Campaign ID -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Campaign ID</label>
                                    <input type="text" name="campaign_id"
                                        value="{{ old('campaign_id', $campaign->campaign_id) }}" class="form-control">
                                </div>

                                <!-- Campaign Type -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Campaign Type</label>
                                    <input type="text" name="campaign_type"
                                        value="{{ old('campaign_type', $campaign->campaign_type) }}" class="form-control"
                                        placeholder="Banner">
                                </div>

                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <div class="container">
                            <h2>Your Ads Placed on Pages </h2><br><br>

                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post">
                                @csrf

                                <div id="url-tech-wrapper">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Tech Properties & URLs</label>

                                        @php
                                            $urlData = json_decode($campaign->url ?? '', true);
                                            if (!is_array($urlData) || empty($urlData)) {
                                                $urlData = [['tech_prop_id' => '', 'url' => '']];
                                            }
                                        @endphp

                                        @foreach ($urlData as $index => $item)
                                            <div class="tech-url-pair mb-2">
                                                <select name="url_data[{{ $index }}][tech_prop_id]"
                                                    class="form-control d-inline-block w-25">
                                                    <option value="" disabled {{ empty($item['tech_prop_id']) ? 'selected' : '' }}>--Select--</option>
                                                    @foreach ($tech_properties as $tech_property)
                                                        <option value="{{ $tech_property->id }}" {{ $item['tech_prop_id'] == $tech_property->id ? 'selected' : '' }}>
                                                            {{ $tech_property->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <input type="text" name="url_data[{{ $index }}][url]"
                                                    class="form-control d-inline-block w-50 ms-2"
                                                    placeholder="http://www.example.com" value="{{ $item['url'] ?? '' }}" />
                                                <i class="bi bi-x-square text-danger ms-2 delete-url"
                                                    style="cursor: pointer;"></i>


                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="button" class="btn-secondary-db mx-2" onclick="addUrlField()">Add
                                        More</button>
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>

                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <div class="container">
                            <h2>Pacing</h2><br><br>


                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post">
                                @csrf

                                <div class="mb-3 d-flex align-items-center gap-4 form-cell">
                                    <label class="form-label fw-semibold">Delivered</label>
                                    <input type="number" step="0.01" name="delivered" id="delivered" class="form-control"
                                        value="{{ old('delivered', $campaign->delivered ?? '') }}" placeholder="75">
                                    %
                                </div>

                                <div class="mb-3 d-flex align-items-center gap-3 form-cell">
                                    <label class="form-label fw-semibold">Remaining</label>
                                    <input type="number" step="0.01" name="remaining" id="remaining" class="form-control"
                                        value="{{ old('remaining', $campaign->remaining ?? '') }}" placeholder="25">
                                    %
                                </div>



                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->


                    <div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                        <div class="container">
                            <h2>Clicks & Impressions </h2><br><br>

                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post">
                                @csrf

                                <div id="metrics-wrapper">
                                    @php
                                        $date = json_decode($campaign->date ?? '[]', true);
                                        $clicks = json_decode($campaign->clicks ?? '[]', true);
                                        $impressions = json_decode($campaign->impressions ?? '[]', true);
                                        $metricsData = [];

                                        if (is_array($date) && is_array($clicks) && is_array($impressions)) {
                                            for ($i = 0; $i < count($date); $i++) {
                                                $metricsData[] = [
                                                    'date' => $date[$i] ?? '',
                                                    'clicks' => $clicks[$i] ?? '',
                                                    'impressions' => $impressions[$i] ?? '',
                                                ];
                                            }

                                        }

                                        if (empty($metricsData)) {
                                            $metricsData = [['date' => '', 'clicks' => '', 'impressions' => '']];
                                        }
                                    @endphp

                                    @foreach ($metricsData as $index => $metric)
                                        <div class="metrics-pair mb-3 align-items-center">
                                            <input type="date" name="metrics_data[{{ $index }}][date]"
                                                class="form-control w-25 me-2 d-inline-block"
                                                value="{{ $metric['date'] ?? '' }}" placeholder="Select Date">
                                            <input type="text" name="metrics_data[{{ $index }}][clicks]"
                                                class="form-control w-25 me-2 d-inline-block" value="{{ $metric['clicks'] }}"
                                                placeholder="Clicks">
                                            <input type="text" name="metrics_data[{{ $index }}][impressions]"
                                                class="form-control w-25 me-2 d-inline-block"
                                                value="{{ $metric['impressions'] }}" placeholder="Impressions">
                                            <i class="bi bi-x-square delete-date text-danger" style="cursor: pointer;"></i>
                                        </div>
                                    @endforeach


                                    <!-- Add & Save Buttons -->
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="button" class="btn-secondary-db mx-2" onclick="addMetricsField()">Add
                                            More</button>
                                        <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab5-tab">
                        <div class="container">
                            <h2>Devices</h2><br><br>

                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post">
                                @csrf

                                <div class="mb-3 d-flex align-items-center gap-4 form-cell">
                                    <label class="form-label fw-semibold">Mobile</label>
                                    <input type="number" step="0.01" id="mobile" name="mobile" class="form-control"
                                        value="{{ old('mobile', $campaign->mobile ?? '') }}" placeholder="75">
                                    %
                                </div>

                                <div class="mb-3 d-flex align-items-center gap-3 form-cell">
                                    <label class="form-label fw-semibold">Desktop</label>
                                    <input type="number" step="0.01" id="desktop" name="desktop" class="form-control"
                                        value="{{ old('desktop', $campaign->desktop ?? '') }}" placeholder="25">%
                                </div>


                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <div class="tab-pane fade" id="tab6" role="tabpanel" aria-labelledby="tab6-tab">
                        <div class="container">
                            <h2>User by Region</h2><br><br>

                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post">
                                @csrf

                                <div id="region-wrapper">
                                    @php
                                        $countries = json_decode($campaign->country ?? '[]', true);
                                        $percentages = json_decode($campaign->percentage ?? '[]', true);
                                        $regionData = [];

                                        if (is_array($countries) && is_array($percentages)) {
                                            for ($i = 0; $i < count($countries); $i++) {
                                                $regionData[] = [
                                                    'country' => $countries[$i] ?? '',
                                                    'percentage' => $percentages[$i] ?? '',
                                                ];
                                            }
                                        }

                                        if (empty($regionData)) {
                                            $regionData = [['country' => '', 'percentage' => '']];
                                        }
                                    @endphp


                                    @foreach ($regionData as $index => $region)
                                        <div class="region-pair mb-3 align-items-center">

                                            <select name="region_data[{{ $index }}][country]"
                                                class="form-control w-25 me-2 d-inline-block">
                                                <option value="">Select Country</option>
                                                <option value="Afghanistan" {{ $region['country'] == 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
                                                <option value="Aland Islands" {{ $region['country'] == 'Aland Islands' ? 'selected' : '' }}>Åland Islands</option>
                                                <option value="Albania" {{ $region['country'] == 'Albania' ? 'selected' : '' }}>
                                                    Albania</option>
                                                <option value="Algeria" {{ $region['country'] == 'Algeria' ? 'selected' : '' }}>
                                                    Algeria</option>
                                                <option value="American Samoa" {{ $region['country'] == 'American Samoa' ? 'selected' : '' }}>American Samoa</option>
                                                <option value="Andorra" {{ $region['country'] == 'Andorra' ? 'selected' : '' }}>
                                                    Andorra</option>
                                                <option value="Angola" {{ $region['country'] == 'Angola' ? 'selected' : '' }}>
                                                    Angola</option>
                                                <option value="Anguilla" {{ $region['country'] == 'Anguilla' ? 'selected' : '' }}>
                                                    Anguilla</option>
                                                <option value="Antarctica" {{ $region['country'] == 'Antarctica' ? 'selected' : '' }}>Antarctica</option>
                                                <option value="Antigua and Barbuda" {{ $region['country'] == 'Antigua and Barbuda' ? 'selected' : '' }}>Antigua and Barbuda</option>
                                                <option value="Argentina" {{ $region['country'] == 'Argentina' ? 'selected' : '' }}>Argentina</option>
                                                <option value="Armenia" {{ $region['country'] == 'Armenia' ? 'selected' : '' }}>
                                                    Armenia</option>
                                                <option value="Aruba" {{ $region['country'] == 'Aruba' ? 'selected' : '' }}>Aruba
                                                </option>
                                                <option value="Australia" {{ $region['country'] == 'Australia' ? 'selected' : '' }}>Australia</option>
                                                <option value="Austria" {{ $region['country'] == 'Austria' ? 'selected' : '' }}>
                                                    Austria</option>
                                                <option value="Azerbaijan" {{ $region['country'] == 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
                                                <option value="Bahamas" {{ $region['country'] == 'Bahamas' ? 'selected' : '' }}>
                                                    Bahamas</option>
                                                <option value="Bahrain" {{ $region['country'] == 'Bahrain' ? 'selected' : '' }}>
                                                    Bahrain</option>
                                                <option value="Bangladesh" {{ $region['country'] == 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
                                                <option value="Barbados" {{ $region['country'] == 'Barbados' ? 'selected' : '' }}>
                                                    Barbados</option>
                                                <option value="Belgium" {{ $region['country'] == 'Belgium' ? 'selected' : '' }}>
                                                    Belgium</option>
                                                <option value="Belize" {{ $region['country'] == 'Belize' ? 'selected' : '' }}>
                                                    Belize</option>
                                                <option value="Benin" {{ $region['country'] == 'Benin' ? 'selected' : '' }}>Benin
                                                </option>
                                                <option value="Bermuda" {{ $region['country'] == 'Bermuda' ? 'selected' : '' }}>
                                                    Bermuda</option>
                                                <option value="Bhutan" {{ $region['country'] == 'Bhutan' ? 'selected' : '' }}>
                                                    Bhutan</option>
                                                <option value="Bolivia" {{ $region['country'] == 'Bolivia' ? 'selected' : '' }}>
                                                    Bolivia</option>
                                                <option value="Bosnia and Herzegovina" {{ $region['country'] == 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
                                                <option value="Botswana" {{ $region['country'] == 'Botswana' ? 'selected' : '' }}>
                                                    Botswana</option>
                                                <option value="Bouvet Island" {{ $region['country'] == 'Bouvet Island' ? 'selected' : '' }}>Bouvet Island</option>
                                                <option value="Brazil" {{ $region['country'] == 'Brazil' ? 'selected' : '' }}>
                                                    Brazil</option>
                                                <option value="British Indian Ocean Territory" {{ $region['country'] == 'British Indian Ocean Territory' ? 'selected' : '' }}>British Indian Ocean Territory
                                                </option>
                                                <option value="Brunei Darussalam" {{ $region['country'] == 'Brunei Darussalam' ? 'selected' : '' }}>Brunei Darussalam</option>
                                                <option value="Bulgaria" {{ $region['country'] == 'Bulgaria' ? 'selected' : '' }}>
                                                    Bulgaria</option>
                                                <option value="Burkina Faso" {{ $region['country'] == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                                <option value="Burma" {{ $region['country'] == 'Burma' ? 'selected' : '' }}>Burma
                                                </option>
                                                <option value="Burundi" {{ $region['country'] == 'Burundi' ? 'selected' : '' }}>
                                                    Burundi</option>
                                                <option value="Cambodia" {{ $region['country'] == 'Cambodia' ? 'selected' : '' }}>
                                                    Cambodia</option>
                                                <option value="Cameroon" {{ $region['country'] == 'Cameroon' ? 'selected' : '' }}>
                                                    Cameroon</option>
                                                <option value="Canada" {{ $region['country'] == 'Canada' ? 'selected' : '' }}>
                                                    Canada</option>
                                                <option value="Cape Verde" {{ $region['country'] == 'Cape Verde' ? 'selected' : '' }}>Cape Verde</option>
                                                <option value="Cayman Islands" {{ $region['country'] == 'Cayman Islands' ? 'selected' : '' }}>Cayman Islands</option>
                                                <option value="Central African Republic" {{ $region['country'] == 'Central African Republic' ? 'selected' : '' }}>Central African Republic</option>
                                                <option value="Chad" {{ $region['country'] == 'Chad' ? 'selected' : '' }}>Chad
                                                </option>
                                                <option value="Chile" {{ $region['country'] == 'Chile' ? 'selected' : '' }}>Chile
                                                </option>
                                                <option value="China" {{ $region['country'] == 'China' ? 'selected' : '' }}>China
                                                </option>
                                                <option value="Christmas Island" {{ $region['country'] == 'Christmas Island' ? 'selected' : '' }}>Christmas Island</option>
                                                <option value="Cocos (Keeling) Islands" {{ $region['country'] == 'Cocos (Keeling) Islands' ? 'selected' : '' }}>Cocos (Keeling) Islands</option>
                                                <option value="Colombia" {{ $region['country'] == 'Colombia' ? 'selected' : '' }}>
                                                    Colombia</option>
                                                <option value="Comoros" {{ $region['country'] == 'Comoros' ? 'selected' : '' }}>
                                                    Comoros</option>
                                                <option value="Congo" {{ $region['country'] == 'Congo' ? 'selected' : '' }}>Congo
                                                </option>
                                                <option value="Congo The Democratic Republic" {{ $region['country'] == 'Congo The Democratic Republic' ? 'selected' : '' }}>Congo The Democratic Republic
                                                </option>
                                                <option value="Cook Islands" {{ $region['country'] == 'Cook Islands' ? 'selected' : '' }}>Cook Islands</option>
                                                <option value="Costa Rica" {{ $region['country'] == 'Costa Rica' ? 'selected' : '' }}>Costa Rica</option>
                                                <option value="Cote Divoire" {{ $region['country'] == 'Cote Divoire' ? 'selected' : '' }}>Cote Divoire</option>
                                                <option value="Croatia" {{ $region['country'] == 'Croatia' ? 'selected' : '' }}>
                                                    Croatia</option>
                                                <option value="Curacao" {{ $region['country'] == 'Curacao' ? 'selected' : '' }}>
                                                    Curacao</option>
                                                <option value="Cyprus" {{ $region['country'] == 'Cyprus' ? 'selected' : '' }}>
                                                    Cyprus</option>
                                                <option value="Czech Republic" {{ $region['country'] == 'Czech Republic' ? 'selected' : '' }}>Czech Republic</option>
                                                <option value="Denmark" {{ $region['country'] == 'Denmark' ? 'selected' : '' }}>
                                                    Denmark</option>
                                                <option value="Djibouti" {{ $region['country'] == 'Djibouti' ? 'selected' : '' }}>
                                                    Djibouti</option>
                                                <option value="Dominica" {{ $region['country'] == 'Dominica' ? 'selected' : '' }}>
                                                    Dominica</option>
                                                <option value="Dominican Republic" {{ $region['country'] == 'Dominican Republic' ? 'selected' : '' }}>Dominican Republic</option>
                                                <option value="East Timor" {{ $region['country'] == 'East Timor' ? 'selected' : '' }}>East Timor</option>
                                                <option value="Ecuador" {{ $region['country'] == 'Ecuador' ? 'selected' : '' }}>
                                                    Ecuador</option>
                                                <option value="Egypt" {{ $region['country'] == 'Egypt' ? 'selected' : '' }}>Egypt
                                                </option>
                                                <option value="El Salvador" {{ $region['country'] == 'El Salvador' ? 'selected' : '' }}>El Salvador</option>
                                                <option value="Equatorial Guinea" {{ $region['country'] == 'Equatorial Guinea' ? 'selected' : '' }}>Equatorial Guinea</option>
                                                <option value="Eritrea" {{ $region['country'] == 'Eritrea' ? 'selected' : '' }}>
                                                    Eritrea</option>
                                                <option value="Estonia" {{ $region['country'] == 'Estonia' ? 'selected' : '' }}>
                                                    Estonia</option>
                                                <option value="Ethiopia" {{ $region['country'] == 'Ethiopia' ? 'selected' : '' }}>
                                                    Ethiopia</option>
                                                <option value="Falkland Islands" {{ $region['country'] == 'Falkland Islands' ? 'selected' : '' }}>Falkland Islands</option>
                                                <option value="Faroe Islands" {{ $region['country'] == 'Faroe Islands' ? 'selected' : '' }}>Faroe Islands</option>
                                                <option value="Fiji" {{ $region['country'] == 'Fiji' ? 'selected' : '' }}>Fiji
                                                </option>
                                                <option value="Finland" {{ $region['country'] == 'Finland' ? 'selected' : '' }}>
                                                    Finland</option>
                                                <option value="France" {{ $region['country'] == 'France' ? 'selected' : '' }}>
                                                    France</option>
                                                <option value="France, Metropolitan" {{ $region['country'] == 'France, Metropolitan' ? 'selected' : '' }}>France, Metropolitan</option>
                                                <option value="French Guiana" {{ $region['country'] == 'French Guiana' ? 'selected' : '' }}>French Guiana</option>
                                                <option value="French Polynesia" {{ $region['country'] == 'French Polynesia' ? 'selected' : '' }}>French Polynesia</option>
                                                <option value="French Southern Territories" {{ $region['country'] == 'French Southern Territories' ? 'selected' : '' }}>French Southern Territories
                                                </option>
                                                <option value="Gabon" {{ $region['country'] == 'Gabon' ? 'selected' : '' }}>Gabon
                                                </option>
                                                <option value="Gambia" {{ $region['country'] == 'Gambia' ? 'selected' : '' }}>
                                                    Gambia</option>
                                                <option value="Georgia" {{ $region['country'] == 'Georgia' ? 'selected' : '' }}>
                                                    Georgia</option>
                                                <option value="Germany" {{ $region['country'] == 'Germany' ? 'selected' : '' }}>
                                                    Germany</option>
                                                <option value="Ghana" {{ $region['country'] == 'Ghana' ? 'selected' : '' }}>Ghana
                                                </option>
                                                <option value="Gibraltar" {{ $region['country'] == 'Gibraltar' ? 'selected' : '' }}>Gibraltar</option>
                                                <option value="Greece" {{ $region['country'] == 'Greece' ? 'selected' : '' }}>
                                                    Greece</option>
                                                <option value="Greenland" {{ $region['country'] == 'Greenland' ? 'selected' : '' }}>Greenland</option>
                                                <option value="Grenada" {{ $region['country'] == 'Grenada' ? 'selected' : '' }}>
                                                    Grenada</option>
                                                <option value="Guadeloupe" {{ $region['country'] == 'Guadeloupe' ? 'selected' : '' }}>Guadeloupe</option>
                                                <option value="Guam" {{ $region['country'] == 'Guam' ? 'selected' : '' }}>Guam
                                                </option>
                                                <option value="Guatemala" {{ $region['country'] == 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
                                                <option value="Guernsey" {{ $region['country'] == 'Guernsey' ? 'selected' : '' }}>
                                                    Guernsey</option>
                                                <option value="Guinea" {{ $region['country'] == 'Guinea' ? 'selected' : '' }}>
                                                    Guinea</option>
                                                <option value="Guinea-Bissau" {{ $region['country'] == 'Guinea-Bissau' ? 'selected' : '' }}>Guinea-Bissau</option>
                                                <option value="Guyana" {{ $region['country'] == 'Guyana' ? 'selected' : '' }}>
                                                    Guyana</option>
                                                <option value="Haiti" {{ $region['country'] == 'Haiti' ? 'selected' : '' }}>Haiti
                                                </option>
                                                <option value="Heard and McDonald Islands" {{ $region['country'] == 'Heard and McDonald Islands' ? 'selected' : '' }}>Heard and McDonald Islands</option>
                                                <option value="Honduras" {{ $region['country'] == 'Honduras' ? 'selected' : '' }}>
                                                    Honduras</option>
                                                <option value="Hong Kong" {{ $region['country'] == 'Hong Kong' ? 'selected' : '' }}>Hong Kong</option>
                                                <option value="Hungary" {{ $region['country'] == 'Hungary' ? 'selected' : '' }}>
                                                    Hungary</option>
                                                <option value="Iceland" {{ $region['country'] == 'Iceland' ? 'selected' : '' }}>
                                                    Iceland</option>
                                                <option value="India" {{ $region['country'] == 'India' ? 'selected' : '' }}>India
                                                </option>
                                                <option value="Indonesia" {{ $region['country'] == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                                <option value="Iraq" {{ $region['country'] == 'Iraq' ? 'selected' : '' }}>Iraq
                                                </option>
                                                <option value="Ireland" {{ $region['country'] == 'Ireland' ? 'selected' : '' }}>
                                                    Ireland</option>
                                                <option value="Isle Of Man" {{ $region['country'] == 'Isle Of Man' ? 'selected' : '' }}>Isle Of Man</option>
                                                <option value="Israel" {{ $region['country'] == 'Israel' ? 'selected' : '' }}>
                                                    Israel</option>
                                                <option value="Italy" {{ $region['country'] == 'Italy' ? 'selected' : '' }}>Italy
                                                </option>
                                                <option value="Jamaica" {{ $region['country'] == 'Jamaica' ? 'selected' : '' }}>
                                                    Jamaica</option>
                                                <option value="Japan" {{ $region['country'] == 'Japan' ? 'selected' : '' }}>Japan
                                                </option>
                                                <option value="Jordan" {{ $region['country'] == 'Jordan' ? 'selected' : '' }}>
                                                    Jordan</option>
                                                <option value="Jersey" {{ $region['country'] == 'Jersey' ? 'selected' : '' }}>
                                                    Jersey</option>
                                                <option value="Kazakhstan" {{ $region['country'] == 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
                                                <option value="Kenya" {{ $region['country'] == 'Kenya' ? 'selected' : '' }}>Kenya
                                                </option>
                                                <option value="Kiribati" {{ $region['country'] == 'Kiribati' ? 'selected' : '' }}>
                                                    Kiribati</option>
                                                <option value="Korea (South)" {{ $region['country'] == 'Korea (South)' ? 'selected' : '' }}>Korea (South)</option>
                                                <option value="Kosovo" {{ $region['country'] == 'Kosovo' ? 'selected' : '' }}>
                                                    Kosovo</option>
                                                <option value="Kuwait" {{ $region['country'] == 'Kuwait' ? 'selected' : '' }}>
                                                    Kuwait</option>
                                                <option value="Kyrgyzstan" {{ $region['country'] == 'Kyrgyzstan' ? 'selected' : '' }}>Kyrgyzstan</option>
                                                <option value="Laos" {{ $region['country'] == 'Laos' ? 'selected' : '' }}>Laos
                                                </option>
                                                <option value="Latvia" {{ $region['country'] == 'Latvia' ? 'selected' : '' }}>
                                                    Latvia</option>
                                                <option value="Lebanon" {{ $region['country'] == 'Lebanon' ? 'selected' : '' }}>
                                                    Lebanon</option>
                                                <option value="Lesotho" {{ $region['country'] == 'Lesotho' ? 'selected' : '' }}>
                                                    Lesotho</option>
                                                <option value="Liberia" {{ $region['country'] == 'Liberia' ? 'selected' : '' }}>
                                                    Liberia</option>
                                                <option value="Libya" {{ $region['country'] == 'Libya' ? 'selected' : '' }}>Libya
                                                </option>
                                                <option value="Macau" {{ $region['country'] == 'Macau' ? 'selected' : '' }}>Macau
                                                </option>
                                                <option value="Macedonia" {{ $region['country'] == 'Macedonia' ? 'selected' : '' }}>Macedonia</option>
                                                <option value="Madagascar" {{ $region['country'] == 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
                                                <option value="Malawi" {{ $region['country'] == 'Malawi' ? 'selected' : '' }}>
                                                    Malawi</option>
                                                <option value="Malaysia" {{ $region['country'] == 'Malaysia' ? 'selected' : '' }}>
                                                    Malaysia</option>
                                                <option value="Maldives" {{ $region['country'] == 'Maldives' ? 'selected' : '' }}>
                                                    Maldives</option>
                                                <option value="Mali" {{ $region['country'] == 'Mali' ? 'selected' : '' }}>Mali
                                                </option>
                                                <option value="Malta" {{ $region['country'] == 'Malta' ? 'selected' : '' }}>Malta
                                                </option>
                                                <option value="Marshall Islands" {{ $region['country'] == 'Marshall Islands' ? 'selected' : '' }}>Marshall Islands</option>
                                                <option value="Martinique" {{ $region['country'] == 'Martinique' ? 'selected' : '' }}>Martinique</option>
                                                <option value="Mauritania" {{ $region['country'] == 'Mauritania' ? 'selected' : '' }}>Mauritania</option>
                                                <option value="Mauritius" {{ $region['country'] == 'Mauritius' ? 'selected' : '' }}>Mauritius</option>
                                                <option value="Mayotte" {{ $region['country'] == 'Mayotte' ? 'selected' : '' }}>
                                                    Mayotte</option>
                                                <option value="Mexico" {{ $region['country'] == 'Mexico' ? 'selected' : '' }}>
                                                    Mexico</option>
                                                <option value="Micronesia" {{ $region['country'] == 'Micronesia' ? 'selected' : '' }}>Micronesia</option>
                                                <option value="Moldova" {{ $region['country'] == 'Moldova' ? 'selected' : '' }}>
                                                    Moldova</option>
                                                <option value="Monaco" {{ $region['country'] == 'Monaco' ? 'selected' : '' }}>
                                                    Monaco</option>
                                                <option value="Mongolia" {{ $region['country'] == 'Mongolia' ? 'selected' : '' }}>
                                                    Mongolia</option>
                                                <option value="Montenegro" {{ $region['country'] == 'Montenegro' ? 'selected' : '' }}>Montenegro</option>
                                                <option value="Montserrat" {{ $region['country'] == 'Montserrat' ? 'selected' : '' }}>Montserrat</option>
                                                <option value="Morocco" {{ $region['country'] == 'Morocco' ? 'selected' : '' }}>
                                                    Morocco</option>
                                                <option value="Mozambique" {{ $region['country'] == 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
                                                <option value="Myanmar" {{ $region['country'] == 'Myanmar' ? 'selected' : '' }}>
                                                    Myanmar</option>
                                                <option value="N. Mariana Islands" {{ $region['country'] == 'N. Mariana Islands' ? 'selected' : '' }}>N. Mariana Islands</option>
                                                <option value="Namibia" {{ $region['country'] == 'Namibia' ? 'selected' : '' }}>
                                                    Namibia</option>
                                                <option value="Nauru" {{ $region['country'] == 'Nauru' ? 'selected' : '' }}>Nauru
                                                </option>
                                                <option value="Nepal" {{ $region['country'] == 'Nepal' ? 'selected' : '' }}>Nepal
                                                </option>
                                                <option value="Netherlands" {{ $region['country'] == 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
                                                <option value="Netherlands Antilles" {{ $region['country'] == 'Netherlands Antilles' ? 'selected' : '' }}>Netherlands Antilles</option>
                                                <option value="New Caledonia" {{ $region['country'] == 'New Caledonia' ? 'selected' : '' }}>New Caledonia</option>
                                                <option value="New Zealand" {{ $region['country'] == 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
                                                <option value="Nicaragua" {{ $region['country'] == 'Nicaragua' ? 'selected' : '' }}>Nicaragua</option>
                                                <option value="Niger" {{ $region['country'] == 'Niger' ? 'selected' : '' }}>Niger
                                                </option>
                                                <option value="Nigeria" {{ $region['country'] == 'Nigeria' ? 'selected' : '' }}>
                                                    Nigeria</option>
                                                <option value="Niue" {{ $region['country'] == 'Niue' ? 'selected' : '' }}>Niue
                                                </option>
                                                <option value="Norfolk Island" {{ $region['country'] == 'Norfolk Island' ? 'selected' : '' }}>Norfolk Island</option>
                                                <option value="Norway" {{ $region['country'] == 'Norway' ? 'selected' : '' }}>
                                                    Norway</option>
                                                <option value="Oman" {{ $region['country'] == 'Oman' ? 'selected' : '' }}>Oman
                                                </option>
                                                <option value="Pakistan" {{ $region['country'] == 'Pakistan' ? 'selected' : '' }}>
                                                    Pakistan</option>
                                                <option value="Palau" {{ $region['country'] == 'Palau' ? 'selected' : '' }}>Palau
                                                </option>
                                                <option value="Palestinian Territory" {{ $region['country'] == 'Palestinian Territory' ? 'selected' : '' }}>Palestinian Territory</option>
                                                <option value="Panama" {{ $region['country'] == 'Panama' ? 'selected' : '' }}>
                                                    Panama</option>
                                                <option value="Papua New Guinea" {{ $region['country'] == 'Papua New Guinea' ? 'selected' : '' }}>Papua New Guinea</option>
                                                <option value="Paraguay" {{ $region['country'] == 'Paraguay' ? 'selected' : '' }}>
                                                    Paraguay</option>
                                                <option value="Peru" {{ $region['country'] == 'Peru' ? 'selected' : '' }}>Peru
                                                </option>
                                                <option value="Philippines" {{ $region['country'] == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                                <option value="Pitcairn" {{ $region['country'] == 'Pitcairn' ? 'selected' : '' }}>
                                                    Pitcairn</option>
                                                <option value="Poland" {{ $region['country'] == 'Poland' ? 'selected' : '' }}>
                                                    Poland</option>
                                                <option value="Portugal" {{ $region['country'] == 'Portugal' ? 'selected' : '' }}>
                                                    Portugal</option>
                                                <option value="Puerto Rico" {{ $region['country'] == 'Puerto Rico' ? 'selected' : '' }}>Puerto Rico</option>
                                                <option value="Qatar" {{ $region['country'] == 'Qatar' ? 'selected' : '' }}>Qatar
                                                </option>
                                                <option value="Reunion" {{ $region['country'] == 'Reunion' ? 'selected' : '' }}>
                                                    Reunion</option>
                                                <option value="Romania" {{ $region['country'] == 'Romania' ? 'selected' : '' }}>
                                                    Romania</option>
                                                <option value="Rwanda" {{ $region['country'] == 'Rwanda' ? 'selected' : '' }}>
                                                    Rwanda</option>
                                                <option value="Saint Barthelemy" {{ $region['country'] == 'Saint Barthelemy' ? 'selected' : '' }}>Saint Barthelemy</option>
                                                <option value="Saint Helena" {{ $region['country'] == 'Saint Helena' ? 'selected' : '' }}>Saint Helena</option>
                                                <option value="Saint Kitts and Nevis" {{ $region['country'] == 'Saint Kitts and Nevis' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
                                                <option value="Saint Lucia" {{ $region['country'] == 'Saint Lucia' ? 'selected' : '' }}>Saint Lucia</option>
                                                <option value="Saint Martin (French Part)" {{ $region['country'] == 'Saint Martin (French Part)' ? 'selected' : '' }}>Saint Martin (French Part)</option>
                                                <option value="Samoa" {{ $region['country'] == 'Samoa' ? 'selected' : '' }}>Samoa
                                                </option>
                                                <option value="San Marino" {{ $region['country'] == 'San Marino' ? 'selected' : '' }}>San Marino</option>
                                                <option value="Sao Tome and Principe" {{ $region['country'] == 'Sao Tome and Principe' ? 'selected' : '' }}>Sao Tome and Principe</option>
                                                <option value="Saudi Arabia" {{ $region['country'] == 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
                                                <option value="Senegal" {{ $region['country'] == 'Senegal' ? 'selected' : '' }}>
                                                    Senegal</option>
                                                <option value="Serbia" {{ $region['country'] == 'Serbia' ? 'selected' : '' }}>
                                                    Serbia</option>
                                                <option value="Seychelles" {{ $region['country'] == 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
                                                <option value="Sierra Leone" {{ $region['country'] == 'Sierra Leone' ? 'selected' : '' }}>Sierra Leone</option>
                                                <option value="Singapore" {{ $region['country'] == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                                <option value="Slovak Republic" {{ $region['country'] == 'Slovak Republic' ? 'selected' : '' }}>Slovak Republic</option>
                                                <option value="Slovakia" {{ $region['country'] == 'Slovakia' ? 'selected' : '' }}>
                                                    Slovakia</option>
                                                <option value="Slovenia" {{ $region['country'] == 'Slovenia' ? 'selected' : '' }}>
                                                    Slovenia</option>
                                                <option value="Solomon Islands" {{ $region['country'] == 'Solomon Islands' ? 'selected' : '' }}>Solomon Islands</option>
                                                <option value="Somalia" {{ $region['country'] == 'Somalia' ? 'selected' : '' }}>
                                                    Somalia</option>
                                                <option value="South Africa" {{ $region['country'] == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                                <option value="South Georgia And The South Sandwich Islands" {{ $region['country'] == 'South Georgia And The South Sandwich Islands' ? 'selected' : '' }}>South Georgia And The South Sandwich Islands</option>
                                                <option value="South Sudan" {{ $region['country'] == 'South Sudan' ? 'selected' : '' }}>South Sudan</option>
                                                <option value="Sudan" {{ $region['country'] == 'Sudan' ? 'selected' : '' }}>Sudan
                                                </option>
                                                <option value="Spain" {{ $region['country'] == 'Spain' ? 'selected' : '' }}>Spain
                                                </option>
                                                <option value="Sri Lanka" {{ $region['country'] == 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
                                                <option value="St. Pierre and Miquelon" {{ $region['country'] == 'St. Pierre and Miquelon' ? 'selected' : '' }}>St. Pierre and Miquelon</option>
                                                <option value="St. Vincent and the Grenadines" {{ $region['country'] == 'St. Vincent and the Grenadines' ? 'selected' : '' }}>St. Vincent and the
                                                    Grenadines</option>
                                                <option value="Suriname" {{ $region['country'] == 'Suriname' ? 'selected' : '' }}>
                                                    Suriname</option>
                                                <option value="Svalbard and Jan Mayen Islands" {{ $region['country'] == 'Svalbard and Jan Mayen Islands' ? 'selected' : '' }}>Svalbard and Jan Mayen Islands
                                                </option>
                                                <option value="Swaziland" {{ $region['country'] == 'Swaziland' ? 'selected' : '' }}>Swaziland</option>
                                                <option value="Sweden" {{ $region['country'] == 'Sweden' ? 'selected' : '' }}>
                                                    Sweden</option>
                                                <option value="Switzerland" {{ $region['country'] == 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
                                                <option value="Taiwan" {{ $region['country'] == 'Taiwan' ? 'selected' : '' }}>
                                                    Taiwan</option>
                                                <option value="Tajikistan" {{ $region['country'] == 'Tajikistan' ? 'selected' : '' }}>Tajikistan</option>
                                                <option value="Tanzania" {{ $region['country'] == 'Tanzania' ? 'selected' : '' }}>
                                                    Tanzania</option>
                                                <option value="Thailand" {{ $region['country'] == 'Thailand' ? 'selected' : '' }}>
                                                    Thailand</option>
                                                <option value="Timor-Leste" {{ $region['country'] == 'Timor-Leste' ? 'selected' : '' }}>Timor-Leste</option>
                                                <option value="Togo" {{ $region['country'] == 'Togo' ? 'selected' : '' }}>Togo
                                                </option>
                                                <option value="Tokelau" {{ $region['country'] == 'Tokelau' ? 'selected' : '' }}>
                                                    Tokelau</option>
                                                <option value="Tonga" {{ $region['country'] == 'Tonga' ? 'selected' : '' }}>Tonga
                                                </option>
                                                <option value="Trinidad and Tobago" {{ $region['country'] == 'Trinidad and Tobago' ? 'selected' : '' }}>Trinidad and Tobago</option>
                                                <option value="Tunisia" {{ $region['country'] == 'Tunisia' ? 'selected' : '' }}>
                                                    Tunisia</option>
                                                <option value="Turkey" {{ $region['country'] == 'Turkey' ? 'selected' : '' }}>
                                                    Turkey</option>
                                                <option value="Turkmenistan" {{ $region['country'] == 'Turkmenistan' ? 'selected' : '' }}>Turkmenistan</option>
                                                <option value="Turks and Caicos Islands" {{ $region['country'] == 'Turks and Caicos Islands' ? 'selected' : '' }}>Turks and Caicos Islands</option>
                                                <option value="Tuvalu" {{ $region['country'] == 'Tuvalu' ? 'selected' : '' }}>
                                                    Tuvalu</option>
                                                <option value="United States" {{ $region['country'] == 'United States' ? 'selected' : '' }}>United States</option>
                                                <option value="Uganda" {{ $region['country'] == 'Uganda' ? 'selected' : '' }}>
                                                    Uganda</option>
                                                <option value="Ukraine" {{ $region['country'] == 'Ukraine' ? 'selected' : '' }}>
                                                    Ukraine</option>
                                                <option value="United Arab Emirates" {{ $region['country'] == 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
                                                <option value="United Kingdom" {{ $region['country'] == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                                                <option value="US Minor Outlying Islands" {{ $region['country'] == 'US Minor Outlying Islands' ? 'selected' : '' }}>US Minor Outlying Islands</option>
                                                <option value="Uruguay" {{ $region['country'] == 'Uruguay' ? 'selected' : '' }}>
                                                    Uruguay</option>
                                                <option value="Uzbekistan" {{ $region['country'] == 'Uzbekistan' ? 'selected' : '' }}>Uzbekistan</option>
                                                <option value="Vanuatu" {{ $region['country'] == 'Vanuatu' ? 'selected' : '' }}>
                                                    Vanuatu</option>
                                                <option value="Vatican City" {{ $region['country'] == 'Vatican City' ? 'selected' : '' }}>Vatican City</option>
                                                <option value="Viet Nam" {{ $region['country'] == 'Viet Nam' ? 'selected' : '' }}>
                                                    Viet Nam</option>
                                                <option value="Virgin Islands (British)" {{ $region['country'] == 'Virgin Islands (British)' ? 'selected' : '' }}>Virgin Islands (British)</option>
                                                <option value="Virgin Islands (U.S.)" {{ $region['country'] == 'Virgin Islands (U.S.)' ? 'selected' : '' }}>Virgin Islands (U.S.)</option>
                                                <option value="Wallis and Futuna Islands" {{ $region['country'] == 'Wallis and Futuna Islands' ? 'selected' : '' }}>Wallis and Futuna Islands</option>
                                                <option value="Western Sahara" {{ $region['country'] == 'Western Sahara' ? 'selected' : '' }}>Western Sahara</option>
                                                <option value="Yemen" {{ $region['country'] == 'Yemen' ? 'selected' : '' }}>Yemen
                                                </option>
                                                <option value="Zambia" {{ $region['country'] == 'Zambia' ? 'selected' : '' }}>
                                                    Zambia</option>
                                                <option value="Zimbabwe" {{ $region['country'] == 'Zimbabwe' ? 'selected' : '' }}>
                                                    Zimbabwe</option>
                                            </select>



                                            <input type="text" name="region_data[{{ $index }}][percentage]"
                                                class="form-control w-25 me-2 d-inline-block"
                                                value="{{ $region['percentage'] }}" placeholder="50%">
                                            <i class="bi bi-x-square delete-region text-danger" style="cursor: pointer;"></i>
                                        </div>
                                    @endforeach

                                </div>

                                <!-- Add & Save Buttons -->
                                <div class="d-flex justify-content-end mt-4">
                                    <button type="button" class="btn-secondary-db mx-2" onclick="addRegionField()">Add
                                        More</button>
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>


                    <!-- ------------------------------------------------------------------------------------------------------------------------------ -->

                    <div class="tab-pane fade" id="tab7" role="tabpanel" aria-labelledby="tab7-tab">
                        <div class="container">
                            <h2>Multiple Ads Format </h2><br><br>

                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf

                                <div id="multiple-ads-wrapper">
                                    @php
                                        // Initialize arrays with empty array as fallback
                                        $single_adpreview = old('single_adpreview', isset($campaign) ? (json_decode($campaign->single_adpreview, true) ?? []) : []);
                                        $single_size = old('single_size', isset($campaign) ? (json_decode($campaign->single_size, true) ?? []) : []);
                                        $single_clicks = old('single_clicks', isset($campaign) ? (json_decode($campaign->single_clicks, true) ?? []) : []);
                                        $single_impressions = old('single_impressions', isset($campaign) ? (json_decode($campaign->single_impressions, true) ?? []) : []);

                                        // Ensure all variables are arrays
                                        $single_adpreview = is_array($single_adpreview) ? $single_adpreview : [];
                                        $single_size = is_array($single_size) ? $single_size : [];
                                        $single_clicks = is_array($single_clicks) ? $single_clicks : [];
                                        $single_impressions = is_array($single_impressions) ? $single_impressions : [];

                                        // Determine the maximum count
                                        $maxCount = max(
                                            count($single_adpreview),
                                            count($single_size),
                                            count($single_clicks),
                                            count($single_impressions)
                                        );
                                    @endphp

                                    @if($maxCount > 0)
                                        @for($i = 0; $i < $maxCount; $i++)
                                            <div class="d-flex align-items-center gap-3 mb-3 multiple-ads-item">
                                                <!-- Ad Preview -->
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="file" name="single_adpreview[]" class="form-control w-auto"
                                                        accept="image/*">

                                                    {{-- Show current image --}}
                                                    @if(!empty($single_adpreview[$i]))
                                                        <div style="width: 60px;">
                                                            <img src="{{ asset($single_adpreview[$i]) }}" alt="Ad Image"
                                                                style="width: 100%;">
                                                        </div>
                                                        {{-- Hidden input to pass old image path --}}
                                                        <input type="hidden" name="existing_single_adpreview[]"
                                                            value="{{ $single_adpreview[$i] }}">
                                                    @else
                                                        <input type="hidden" name="existing_single_adpreview[]" value="">
                                                    @endif
                                                </div>

                                                <!-- Ad Size -->
                                                <input type="text" name="single_size[]" class="form-control"
                                                    placeholder="Size (e.g. 300x250)" value="{{ $single_size[$i] ?? '' }}">

                                                <!-- Clicks -->
                                                <input type="number" name="single_clicks[]" class="form-control"
                                                    placeholder="Clicks" value="{{ $single_clicks[$i] ?? '' }}">

                                                <!-- Impressions -->
                                                <input type="number" name="single_impressions[]" class="form-control"
                                                    placeholder="Impressions" value="{{ $single_impressions[$i] ?? '' }}">

                                                <i class="bi bi-x-square text-danger" onclick="removeMultipleAds(this)"
                                                    style="cursor: pointer;"></i>
                                            </div>
                                        @endfor
                                    @else
                                        <!-- Empty field if no data -->
                                        <div class="d-flex align-items-center gap-3 mb-3 multiple-ads-item">
                                            <!-- Ad Preview -->
                                            <input type="file" name="single_adpreview[]" class="form-control w-auto"
                                                accept="image/*">

                                            <!-- Ad Size -->
                                            <input type="text" name="single_size[]" class="form-control"
                                                placeholder="Size (e.g. 300x250)">

                                            <!-- Clicks -->
                                            <input type="number" name="single_clicks[]" class="form-control"
                                                placeholder="Clicks">

                                            <!-- Impressions -->
                                            <input type="number" name="single_impressions[]" class="form-control"
                                                placeholder="Impressions">

                                            <i class="bi bi-x-square text-danger" onclick="removeMultipleAds(this)"
                                                style="cursor: pointer;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="button" class="btn-secondary-db mx-2" onclick="AddMultipleAds()">Add
                                        More</button>
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- -----------------------------------------------------------------------------------------------------------------------------  -->

                    <div class="tab-pane fade" id="tab8" role="tabpanel" aria-labelledby="tab8-tab">
                        <div class="container">
                            <h2>Top Sites </h2><br><br>

                            <form
                                action="{{ isset($campaign) ? route('ad-campaign.update', $campaign->id) : route('ad-campaign.save') }}"
                                method="post" enctype="multipart/form-data">
                                @csrf

                                <div id="top-sites-wrapper">
                                    @php
                                        // If editing, get top_sites as an array
                                        $topSites = old('top_sites', isset($campaign) ? json_decode($campaign->top_sites, true) : []);
                                    @endphp

                                    @if(!empty($topSites))
                                        @foreach($topSites as $site)
                                            <div class="d-flex align-items-center gap-3 mb-3 top-site-item">
                                                <input type="text" name="top_sites[]" class="form-control"
                                                    placeholder="www.example.com" value="{{ $site }}">
                                                <i class="bi bi-x-square text-danger" onclick="removeTopSites(this)"
                                                    style="cursor: pointer;"></i>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Empty field if no data -->
                                        <div class="d-flex align-items-center gap-3 mb-3 top-site-item">
                                            <input type="text" name="top_sites[]" class="form-control"
                                                placeholder="www.example.com" value="">
                                            <i class="bi bi-x-square text-danger" onclick="removeTopSites(this)"
                                                style="cursor: pointer;"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Save Button -->
                                <div class="d-flex justify-content-end mt-5">
                                    <button type="button" class="btn-secondary-db mx-2" onclick="addTopSites()">Add
                                        More</button>
                                    <button type="submit" class="btn-primary-db fw-semibold px-5">Save</button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <!-- -----------------------------------------------------------------------------------------------------------------------------  -->
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    let count = {{ isset($urlData) ? count($urlData) : 1 }};
    function addUrlField() {
        const wrapper = document.getElementById('url-tech-wrapper');
        const newField = document.createElement('div');
        newField.classList.add('tech-url-pair', 'mb-2');
        newField.innerHTML = `
            <select name="url_data[${count}][tech_prop_id]" class="form-control d-inline-block w-25">
                <option value="" selected disabled>--Select--</option>
                @foreach ($tech_properties as $tech_property)
                    <option value="{{ $tech_property->id }}">{{ $tech_property->name }}</option>
                @endforeach
            </select>

            <input type="text" name="url_data[${count}][url]" class="form-control d-inline-block w-50 ms-2" placeholder="http://www.example.com" />
            <i class="bi bi-x-square delete-url" style="color:#DC3C6B;margin-left: 7px;"></i>
        `;
        wrapper.appendChild(newField);
        count++;
    }

    //delete url function 
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-url')) {
            if (confirm('Are you sure you want to delete this entry?')) {
                e.target.closest('.tech-url-pair').remove();
            }
        }
    });

    //User by Region logic
    let regionCount = {{ $count ?? 1 }};

    function addRegionField() {
        let container = document.getElementById('region-wrapper');
        let index = container.children.length;
        let div = document.createElement('div');
        div.className = 'region-pair mb-3 align-items-center';

        const countryOptions = `
        <option value="Afghanistan">Afghanistan</option>
        <option value="Åland Islands">Åland Islands</option>
        <option value="Albania">Albania</option>
        <option value="Algeria">Algeria</option>
        <option value="American Samoa">American Samoa</option>
        <option value="Andorra">Andorra</option>
        <option value="Angola">Angola</option>
        <option value="Anguilla">Anguilla</option>
        <option value="Antarctica">Antarctica</option>
        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
        <option value="Argentina">Argentina</option>
        <option value="Armenia">Armenia</option>
        <option value="Aruba">Aruba</option>
        <option value="Australia">Australia</option>
        <option value="Austria">Austria</option>
        <option value="Azerbaijan">Azerbaijan</option>
        <option value="Bahamas">Bahamas</option>
        <option value="Bahrain">Bahrain</option>
        <option value="Bangladesh">Bangladesh</option>
        <option value="Barbados">Barbados</option>
        <option value="Belgium">Belgium</option>
        <option value="Belize">Belize</option>
        <option value="Benin">Benin</option>
        <option value="Bermuda">Bermuda</option>
        <option value="Bhutan">Bhutan</option>
        <option value="Bolivia">Bolivia</option>
        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
        <option value="Botswana">Botswana</option>
        <option value="Bouvet Island">Bouvet Island</option>
        <option value="Brazil">Brazil</option>
        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
        <option value="Brunei Darussalam">Brunei Darussalam</option>
        <option value="Bulgaria">Bulgaria</option>
        <option value="Burkina Faso">Burkina Faso</option>
        <option value="Burma">Burma</option>
        <option value="Burundi">Burundi</option>
        <option value="Cambodia">Cambodia</option>
        <option value="Cameroon">Cameroon</option>
        <option value="Canada">Canada</option>
        <option value="Cape Verde">Cape Verde</option>
        <option value="Cayman Islands">Cayman Islands</option>
        <option value="Central African Republic">Central African Republic</option>
        <option value="Chad">Chad</option>
        <option value="Chile">Chile</option>
        <option value="China">China</option>
        <option value="Christmas Island">Christmas Island</option>
        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
        <option value="Colombia">Colombia</option>
        <option value="Comoros">Comoros</option>
        <option value="Congo">Congo</option>
        <option value="Congo The Democratic Republic">Congo The Democratic Republic</option>
        <option value="Cook Islands">Cook Islands</option>
        <option value="Costa Rica">Costa Rica</option>
        <option value="Cote Divoire">Cote Divoire</option>
        <option value="Croatia">Croatia</option>
        <option value="Curacao">Curacao</option>
        <option value="Cyprus">Cyprus</option>
        <option value="Czech Republic">Czech Republic</option>
        <option value="Denmark">Denmark</option>
        <option value="Djibouti">Djibouti</option>
        <option value="Dominica">Dominica</option>
        <option value="Dominican Republic">Dominican Republic</option>
        <option value="East Timor">East Timor</option>
        <option value="Ecuador">Ecuador</option>
        <option value="Egypt">Egypt</option>
        <option value="El Salvador">El Salvador</option>
        <option value="Equatorial Guinea">Equatorial Guinea</option>
        <option value="Eritrea">Eritrea</option>
        <option value="Estonia">Estonia</option>
        <option value="Ethiopia">Ethiopia</option>
        <option value="Falkland Islands">Falkland Islands</option>
        <option value="Faroe Islands">Faroe Islands</option>
        <option value="Fiji">Fiji</option>
        <option value="Finland">Finland</option>
        <option value="France">France</option>
        <option value="France, Metropolitan">France, Metropolitan</option>
        <option value="French Guiana">French Guiana</option>
        <option value="French Polynesia">French Polynesia</option>
        <option value="French Southern Territories">French Southern Territories</option>
        <option value="Gabon">Gabon</option>
        <option value="Gambia">Gambia</option>
        <option value="Georgia">Georgia</option>
        <option value="Germany">Germany</option>
        <option value="Ghana">Ghana</option>
        <option value="Gibraltar">Gibraltar</option>
        <option value="Greece">Greece</option>
        <option value="Greenland">Greenland</option>
        <option value="Grenada">Grenada</option>
        <option value="Guadeloupe">Guadeloupe</option>
        <option value="Guam">Guam</option>
        <option value="Guatemala">Guatemala</option>
        <option value="Guernsey">Guernsey</option>
        <option value="Guinea">Guinea</option>
        <option value="Guinea-Bissau">Guinea-Bissau</option>
        <option value="Guyana">Guyana</option>
        <option value="Haiti">Haiti</option>
        <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>
        <option value="Honduras">Honduras</option>
        <option value="Hong Kong">Hong Kong</option>
        <option value="Hungary">Hungary</option>
        <option value="Iceland">Iceland</option>
        <option value="India">India</option>
        <option value="Indonesia">Indonesia</option>
        <option value="Iraq">Iraq</option>
        <option value="Ireland">Ireland</option>
        <option value="Isle Of Man">Isle Of Man</option>
        <option value="Israel">Israel</option>
        <option value="Italy">Italy</option>
        <option value="Jamaica">Jamaica</option>
        <option value="Japan">Japan</option>
        <option value="Jordan">Jordan</option>
        <option value="Jersey">Jersey</option>
        <option value="Kazakhstan">Kazakhstan</option>
        <option value="Kenya">Kenya</option>
        <option value="Kiribati">Kiribati</option>
        <option value="Korea (South)">Korea (South)</option>
        <option value="Kosovo">Kosovo</option>
        <option value="Kuwait">Kuwait</option>
        <option value="Kyrgyzstan">Kyrgyzstan</option>
        <option value="Laos">Laos</option>
        <option value="Latvia">Latvia</option>
        <option value="Lebanon">Lebanon</option>
        <option value="Lesotho">Lesotho</option>
        <option value="Liberia">Liberia</option>
        <option value="Libya">Libya</option>
        <option value="Liechtenstein">Liechtenstein</option>
        <option value="Lithuania">Lithuania</option>
        <option value="Luxembourg">Luxembourg</option>
        <option value="Macau">Macau</option>
        <option value="Macedonia">Macedonia</option>
        <option value="Madagascar">Madagascar</option>
        <option value="Malawi">Malawi</option>
        <option value="Malaysia">Malaysia</option>
        <option value="Maldives">Maldives</option>
        <option value="Mali">Mali</option>
        <option value="Malta">Malta</option>
        <option value="Marshall Islands">Marshall Islands</option>
        <option value="Martinique">Martinique</option>
        <option value="Mauritania">Mauritania</option>
        <option value="Mauritius">Mauritius</option>
        <option value="Mayotte">Mayotte</option>
        <option value="Mexico">Mexico</option>
        <option value="Micronesia">Micronesia</option>
        <option value="Moldova">Moldova</option>
        <option value="Monaco">Monaco</option>
        <option value="Mongolia">Mongolia</option>
        <option value="Montenegro">Montenegro</option>
        <option value="Montserrat">Montserrat</option>
        <option value="Morocco">Morocco</option>
        <option value="Mozambique">Mozambique</option>
        <option value="Myanmar">Myanmar</option>
        <option value="N. Mariana Islands">N. Mariana Islands</option>
        <option value="Namibia">Namibia</option>
        <option value="Nauru">Nauru</option>
        <option value="Nepal">Nepal</option>
        <option value="Netherlands">Netherlands</option>
        <option value="Netherlands Antilles">Netherlands Antilles</option>
        <option value="New Caledonia">New Caledonia</option>
        <option value="New Zealand">New Zealand</option>
        <option value="Nicaragua">Nicaragua</option>
        <option value="Niger">Niger</option>
        <option value="Nigeria">Nigeria</option>
        <option value="Niue">Niue</option>
        <option value="Norfolk Island">Norfolk Island</option>
        <option value="Norway">Norway</option>
        <option value="Oman">Oman</option>
        <option value="Pakistan">Pakistan</option>
        <option value="Palau">Palau</option>
        <option value="Palestinian Territory">Palestinian Territory</option>
        <option value="Panama">Panama</option>
        <option value="Papua New Guinea">Papua New Guinea</option>
        <option value="Paraguay">Paraguay</option>
        <option value="Peru">Peru</option>
        <option value="Philippines">Philippines</option>
        <option value="Pitcairn">Pitcairn</option>
        <option value="Poland">Poland</option>
        <option value="Portugal">Portugal</option>
        <option value="Puerto Rico">Puerto Rico</option>
        <option value="Qatar">Qatar</option>
        <option value="Reunion">Reunion</option>
        <option value="Romania">Romania</option>
        <option value="Rwanda">Rwanda</option>
        <option value="Saint Barthelemy">Saint Barthelemy</option>
        <option value="Saint Helena">Saint Helena</option>
        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
        <option value="Saint Lucia">Saint Lucia</option>
        <option value="Saint Martin (French Part)">Saint Martin (French Part)</option>
        <option value="Samoa">Samoa</option>
        <option value="San Marino">San Marino</option>
        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
        <option value="Saudi Arabia">Saudi Arabia</option>
        <option value="Senegal">Senegal</option>
        <option value="Serbia">Serbia</option>
        <option value="Seychelles">Seychelles</option>
        <option value="Sierra Leone">Sierra Leone</option>
        <option value="Singapore">Singapore</option>
        <option value="Slovak Republic">Slovak Republic</option>
        <option value="Slovakia">Slovakia</option>
        <option value="Slovenia">Slovenia</option>
        <option value="Solomon Islands">Solomon Islands</option>
        <option value="Somalia">Somalia</option>
        <option value="South Africa">South Africa</option>
        <option value="South Georgia And The South Sandwich Islands">South Georgia And The South Sandwich Islands</option>
        <option value="South Sudan">South Sudan</option>
        <option value="Sudan">Sudan</option>
        <option value="Spain">Spain</option>
        <option value="Sri Lanka">Sri Lanka</option>
        <option value="St. Pierre and Miquelon">St. Pierre and Miquelon</option>
        <option value="St. Vincent and the Grenadines">St. Vincent and the Grenadines</option>
        <option value="Suriname">Suriname</option>
        <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>
        <option value="Swaziland">Swaziland</option>
        <option value="Sweden">Sweden</option>
        <option value="Switzerland">Switzerland</option>
        <option value="Taiwan">Taiwan</option>
        <option value="Tajikistan">Tajikistan</option>
        <option value="Tanzania">Tanzania</option>
        <option value="Thailand">Thailand</option>
        <option value="Timor-Leste">Timor-Leste</option>
        <option value="Togo">Togo</option>
        <option value="Tokelau">Tokelau</option>
        <option value="Tonga">Tonga</option>
        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
        <option value="Tunisia">Tunisia</option>
        <option value="Turkey">Turkey</option>
        <option value="Turkmenistan">Turkmenistan</option>
        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
        <option value="Tuvalu">Tuvalu</option>
        <option value="United States">United States</option>
        <option value="Uganda">Uganda</option>
        <option value="Ukraine">Ukraine</option>
        <option value="United Arab Emirates">United Arab Emirates</option>
        <option value="United Kingdom">United Kingdom</option>
        <option value="US Minor Outlying Islands">US Minor Outlying Islands</option>
        <option value="Uruguay">Uruguay</option>
        <option value="Uzbekistan">Uzbekistan</option>
        <option value="Vanuatu">Vanuatu</option>
        <option value="Vatican City">Vatican City</option>
        <option value="Viet Nam">Viet Nam</option>
        <option value="Virgin Islands (British)">Virgin Islands (British)</option>
        <option value="Virgin Islands (U.S.)">Virgin Islands (U.S.)</option>
        <option value="Wallis and Futuna Islands">Wallis and Futuna Islands</option>
        <option value="Western Sahara">Western Sahara</option>
        <option value="Yemen">Yemen</option>
        <option value="Zambia">Zambia</option>
        <option value="Zimbabwe">Zimbabwe</option>

    `;

        div.innerHTML = `
      
         <select name="region_data[${index}][country]" class="form-control w-25 me-2 d-inline-block">
            ${countryOptions}
        </select>
        <input type="text" name="region_data[${index}][percentage]" class="form-control w-25 me-2 d-inline-block" placeholder="50%" />

        <i class="bi bi-x-square delete-region text-danger" style="cursor: pointer;"></i>
    `;
        container.appendChild(div);
    }

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-region')) {
            e.target.parentElement.remove();
        }
    });


    //clicks and impressions logic
    let mertricsCount = {{ $count ?? 1 }};

    function addMetricsField() {
        let container = document.getElementById('metrics-wrapper');
        let index = container.children.length;
        let div = document.createElement('div');
        div.className = 'metrics-pair mb-3 align-items-center';
        div.innerHTML = `
        <input type="date" name="metrics_data[${index}][date]" class="form-control w-25 me-2 d-inline-block" placeholder="Date" />
        <input type="text" name="metrics_data[${index}][clicks]" class="form-control w-25 me-2 d-inline-block" placeholder="Clicks" />
        <input type="text" name="metrics_data[${index}][impressions]" class="form-control w-25 me-2 d-inline-block" placeholder="Impressions" />
        <i class="bi bi-x-square delete-date text-danger" style="cursor: pointer;"></i>
    `;
        container.appendChild(div);
    }

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('delete-date')) {
            e.target.parentElement.remove();
        }
    });


    //percentage logic
    document.addEventListener("DOMContentLoaded", function () {
        function linkPercentageInputs(inputAId, inputBId) {
            const inputA = document.getElementById(inputAId);
            const inputB = document.getElementById(inputBId);

            inputA.addEventListener("input", () => {
                const valueA = parseFloat(inputA.value);
                if (!isNaN(valueA)) {
                    inputB.value = (100 - valueA).toFixed(2);
                }
            });

            inputB.addEventListener("input", () => {
                const valueB = parseFloat(inputB.value);
                if (!isNaN(valueB)) {
                    inputA.value = (100 - valueB).toFixed(2);
                }
            });
        }

        // Use for Delivered/Remaining
        linkPercentageInputs("delivered", "remaining");

        // Use for Mobile/Desktop
        linkPercentageInputs("mobile", "desktop");
    });

    function AddMultipleAds() {
        const wrapper = document.getElementById('multiple-ads-wrapper');

        const fieldHTML = `
        <div class="d-flex align-items-center gap-3 mb-3">
            <!-- Ad Preview -->
            <input type="file" name="single_adpreview[]" class="form-control w-auto" accept="image/*">

            <!-- Ad Size -->
            <input type="text" name="single_size[]" class="form-control" placeholder="Size (e.g. 300x250)">

            <!-- Clicks -->
            <input type="number" name="single_clicks[]" class="form-control" placeholder="Clicks" min="0">

            <!-- Impressions -->
            <input type="number" name="single_impressions[]" class="form-control" placeholder="Impressions" min="0">

            <i class="bi bi-x-square text-danger" onclick="removeMultipleAds(this)" style="cursor: pointer;"></i>
        </div>
    `;

        wrapper.insertAdjacentHTML('beforeend', fieldHTML);
    }

    function removeMultipleAds(element) {
        const item = element.closest('.multiple-ads-item');
        if (item && document.querySelectorAll('.multiple-ads-item').length > 1) {
            item.remove();
        }
    }

    function addTopSites() {
        const wrapper = document.getElementById('top-sites-wrapper');
        const fieldHTML = `
        <div class="d-flex align-items-center gap-3 mb-3">
            <!-- add link -->
            <input type="text" name="top_sites[]" class="form-control" placeholder="www.example.com" value="">

            <i class="bi bi-x-square text-danger" onclick="removeTopSites(this)" style="cursor: pointer;"></i>
        </div>
    `;

        wrapper.insertAdjacentHTML('beforeend', fieldHTML);
    }

    function removeTopSites(button) {
        button.closest('.d-flex').remove();
    }

</script>