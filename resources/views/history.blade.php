@extends('layout.master')

@section('title', 'History')

@section('content')
<div class="min-heigt">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ __('history.history') }}</h1>
            <div>
                <label for="filter" class="form-label me-2">{{ __('history.filter') }}</label>
                <select id="filter" class="form-select d-inline-block w-auto">
                    <!-- <option value="all" {{ $currentFilter == 'all' ? 'selected' : '' }}>---</option> -->
                    <option value="all" {{ $currentFilter == 'all' ? 'selected' : '' }}>{{ __('history.all') }}</option>
                    <option value="donation" {{ $currentFilter == 'donation' ? 'selected' : '' }}>{{ __('history.donation') }}</option>
                    <option value="share" {{ $currentFilter == 'share' ? 'selected' : '' }}>{{ __('history.share') }}</option>
                </select>
            </div>
        </div>

    @if ($histories != null)
    @foreach ($histories as $history)
        @if ($history->activity_type == 'donation')
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <img src="https://via.placeholder.com/40" alt="Profile Icon" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                        <strong>{{ $history->user->name }}</strong>
                    </div>
                        <h5 class="card-title mb-4 my-4">{{ __('history.made_donation') }} {{ $history->donations->amount }}</h5>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span>{{ __('history.status') }}</span>
                                @if ($history->donations->status == "completed")    
                                    <span class="status-box status-active">{{ $history->donations->status }}</span>
                                @else
                                    <span class="status-box status-active" style="background-color: gray">{{ $history->donations->status }}</span>
                                    <!-- <a href="{{ route('payment.process', ['id' => $history->donations->id]) }}" class="btn btn-primary mt-2">{{ __('history.pay_now') }}</a> -->
                                    <!-- <button class="btn btn-primary mt-2" onclick="window.location.href='{{ route('payment.process', ['id' => $history->donations->id]) }}'">{{ __('history.pay_now') }}</button> -->
                                    <button id="payButton" class="btn btn-primary" onclick="window.location.href='{{ route('payment.process', ['id' => $history->donations->id]) }}'">
                                        {{ __('payment.pay_now') }}
                                    </button>
                                @endif

                            </div>
                        </div>
                </div>
            </div>
        @else
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <img src="https://via.placeholder.com/40" alt="Profile Icon" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                        <strong>{{ $history->user->name }}</strong>
                    </div>

                    @if ($history->shares)
                        <h5 class="card-title mb-4 my-4">You make an event called '{{ $history->shares->event_name }}'. In order to distribute {{ $history->shares->food_type }} to {{ $history->shares->estimated_people }} with a budget of Rp. {{ $history->shares->budget }}</h5>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center mb-1">
                                <i class="fa-solid fa-calendar me-2"></i>
                                <span>{{ $history->shares->distribution_date }}</span>
                            </div>

                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-location-dot me-2"></i>
                                <span>{{ $history->shares->distribution_address }}</span>
                            </div>

                            <div>
                                <span>{{ __('history.status') }}</span>
                                @if ($history->shares->status == "completed")    
                                    <span class="status-box status-active">{{ $history->shares->status }}</span>
                                @else
                                    <span class="status-box status-active" style="background-color: gray">{{ $history->shares->status }}</span>
                                @endif
                            </div>

                            <div class="view">
                                <a href={{ route('tracking', ['id' => $history->shares->id]) }} class="btn btn-link">{{ __('history.view') }} >></a>
                            </div>
                        </div>
                        @else
                            <p class="text-muted">{{ __('history.no_share_details') }}<</p>
                        @endif
                    </div>
                </div>
            @endif
        @endforeach
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
        {{ $histories->links('pagination::bootstrap-5') }}
        </div>
    @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/history.css') }}">
<script>
    document.getElementById('filter').addEventListener('change', function () {
        const type = this.value; 
        const url = `/history/${type}`; 
        window.location.href = url;
    });
</script>
@endpush