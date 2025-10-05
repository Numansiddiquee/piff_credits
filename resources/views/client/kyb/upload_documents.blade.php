@extends('layouts.custom.client')

@section('client-css')
    <script src="https://static.sumsub.com/idensic/static/sns-websdk-builder.js"></script>
@endsection

@section('client-content')
<div id="kt_app_toolbar" class="app-toolbar pt-0 pb-2">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
        <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
            <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                    <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">KYB Verification</h1>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="{{ route('client.kyb') }}" class="btn btn-flex btn-danger h-40px fs-7 fw-bold">Close</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-5 mb-xl-8">
    <div class="card-body py-3">
        <div id="sumsub-websdk-container"></div>
    </div>
</div>
@endsection

@section('client-js')
<script>
    function getNewAccessToken() {
        return fetch("{{ route('client.kyb.token') }}")
            .then(res => res.json())
            .then(data => data.token);
    }

    function launchWebSdk(accessToken) {
        if (!accessToken) {
            console.error("No access token provided");
            return;
        }

        let snsWebSdkInstance = snsWebSdk
            .init(accessToken, getNewAccessToken)
            .withConf({
                lang: "en",
                email: "{{ auth()->user()->email }}",
                phone: "{{ auth()->user()->phone ?? '' }}",
            })
            .withOptions({ addViewportTag: false, adaptIframeHeight: true })
            .on("idCheck.onStepCompleted", payload => console.log("onStepCompleted", payload))
            .on("idCheck.onError", error => console.error("onError", error))
            .onMessage((type, payload) => console.log("onMessage", type, payload))
            .build();

        snsWebSdkInstance.launch("#sumsub-websdk-container");
    }

    launchWebSdk("{{ $accessToken }}");
</script>
@endsection
