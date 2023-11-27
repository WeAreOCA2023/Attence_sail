@extends('layouts.fixed')

@section('content')
<div class="profile d-flex flex-column justify-content-between h-100 mx-auto py-4">
    <div class="upperBox d-flex">
        <div class="upperLeftBox d-flex flex-column items-center text-center justify-content-center">
            <img class="mx-auto" src="{{ asset('img/profileIcon.svg') }}" alt="Profile Icon">
            <h3>{{ $full_name }}</h3>
            <div class="creditScore d-flex flex-column w-fit-content">
                <label class="text-left" for="creditScore">信頼スコア</label>
                <progress class="mx-auto" id="creditScore" value="88" max="100">88%</progress>
            </div>
        </div>
        <div class="upperRightBox d-flex flex-column">
            <div class="upperRightTopBox d-flex flex-column items-center justify-content-center">
                <div class="d-flex mb-4">
                    <img src="{{ asset('img/user-setting.svg') }}" alt="User Setting Icon">
                    <h2 class="m-0">個人設定</h2>
                </div>
                <div class="d-flex justify-content-around mt-auto mb-auto">
                    <div class="email">
                        <h3 class="m-0">Eメール:{{ Auth::user()->email }}</h3>
                    </div>
                    <div class="phoneNumber">
                        <h3 class="m-0">電話番号:{{ $phone_number }}</h3>
                    </div>
                    <div class="password">
                        <h3 class="m-0">パスワード:******</h3>
                    </div>
                </div>
            </div>
            <div class="upperRightMiddleBox d-flex flex-column items-center justify-content-center">
                <div class="d-flex mb-4">
                    <img src="{{ asset('img/company-setting.svg') }}" alt="Company Setting Icon">
                    <h2 class="m-0">会社設定</h2>
                </div>
                <div class="d-flex justify-content-around mt-auto mb-auto">
                    <h3 class="m-0">会社名:{{ $company_name }}</h3>
                    <h3 class="m-0">役職:{!! $position_name !!}</h3>
                    <h3 class="m-0">部署:{!! $department_name !!}</h3>
                    <h3 class="m-0">36協定:{!! $agreement_36 !!}</h3>
                    <h3 class="m-0">変形労働時間制:{!! $variable_working_hours_system !!}</h3>
                </div>
            </div>
            <div class="upperRightBottomBox d-flex flex-column items-center justify-content-center">
                <div class="d-flex mb-4">
                    <img src="{{ asset('img/task-setting.svg') }}" alt="Task Result Icon">
                    <h2 class="m-0">過去のタスク履歴</h2>
                </div>
                <div class="d-flex justify-content-around mt-auto mb-auto">
                    <h3 class="m-0">割り当て数:{{ $assigned_tasks }}</h3>
                    <h3 class="m-0">期限内達成数:</h3>
                    <h3 class="m-0">期限後達成数:</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="lowerBox d-flex justify-content-around">
        <div class="lawBox  d-flex flex-column align-items-center justify-content-center">
            <div class="title d-flex align-items-center mt-5">
                <img src="{{ asset('img/contract.svg') }}" alt="Contract Setting Icon">
                <h2 class="m-0">契約情報</h2>
            </div>
            <div class="lawBoxInner d-flex flex-column justify-content-center align-items-center mb-auto mt-auto">
                <form class="d-flex flex-column align-items-center justify-content-between" action="{{ route('profile.updateContract', Auth::user()->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if (session('successAgreement'))
                        <div class="success d-block text-center">
                            <strong>{{ session('successAgreement') }}</strong>
                        </div>
                    @endif
                    <div class="agreement36Box">
                        @error('agreement36')
                            <span class="error d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="agreement36Input">
                            <label for="companyName">{{ __('36協定') }}</label>
                            <select class="form-select" aria-label="Agreement 36" name="agreement36">
                                <option selected value="0">未選択</option>
                                <option value="1">有り</option>
                                <option value="2">特別条項付き36協定</option>
                                <option value="3">無し</option>
                            </select>
                        </div>
                    </div>
                    <div class="variableWorkingHoursSystemBox">
                        <label for="variableWorkingHoursSystem">{{ __('変形労働時間制') }}</label>
                        <div class="variableWorkingHoursSystemInput">
                            <select class="form-select" aria-label="Variable Working Hours System" name="variableWorkingHoursSystem">
                                <option selected value="0">未選択</option>
                                <option value="1">有り</option>
                                <option value="2">無し</option>
                            </select>
                        </div>
                    </div>
                    <div class="saveButton text-center">
                        <button type="submit">
                            {{ __('保存') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="accountOuterBox d-flex">
            <div class="accountBox  d-flex flex-column align-items-center justify-content-center">
                <div class="title d-flex align-items-center mt-5">
                    <img src="{{ asset('img/user-setting.svg') }}" alt="User Setting Icon">
                    <h2 class="m-0">アカウント情報</h2>
                </div>
                @if (session('successFullName'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successFullName') }}</strong>
                    </div>
                @endif
                @if (session('successUserName'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successUserName') }}</strong>
                    </div>
                @endif
                @if (session('successEmail'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successEmail') }}</strong>
                    </div>
                @endif
                @if (session('successTelephone'))
                    <div class="success d-block text-center">
                        <strong>{{ session('successTelephone') }}</strong>
                    </div>
                @endif
                <div class="accountInnerBox d-flex flex-column justify-content-center align-items-center mb-auto mt-auto">
                    <form class="d-flex flex-column align-items-center justify-content-between" action="{{ route('profile.updateFullName', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="fullNameBox d-flex flex-column">
                            <label for="fullName">{{ __('名前') }}</label>
                            <div class="fullNameInput d-flex">
                                <input id="fullName" type="text"  name="fullName" value="{{ old('fullName') }}" autocomplete="off">
                                <button class="saveButton" type="submit">
                                    {{ __('保存') }}
                                </button>
                            </div>
                            @error('fullName')
                                <span class="error d-block text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                    <form class="d-flex flex-column align-items-center justify-content-between" action="{{ route('profile.updateUserName', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="userNameBox">
                            <label for="userName">{{ __('ユーザー名') }}</label>
                            <div class="userNameInput">
                                <input id="userName" type="text"  name="userName" value="{{ old('userName') }}" autocomplete="off">
                                <button class="saveButton" type="submit">
                                    {{ __('保存') }}
                                </button>
                            </div>
                            @error('userName')
                                <span class="error d-block text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                    <form class="d-flex flex-column align-items-center justify-content-between" action="{{ route('profile.updateEmail', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="emailBox">
                            <label for="email">{{ __('Eメール') }}</label>
                            <div class="emailInput">
                                <input id="email" type="text"  name="email" value="{{ old('email') }}" autocomplete="off">
                                <button class="saveButton" type="submit">
                                    {{ __('保存') }}
                                </button>
                            </div>
                            @error('email')
                                <span class="error d-block text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                    <form class="d-flex flex-column align-items-center justify-content-between" action="{{ route('profile.updateTelephone', Auth::user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="telephoneBox">
                            <label for="telephone">{{ __('電話番号') }}</label>
                            <div class="telephoneInput">
                                <input id="telephone" type="tel"  name="telephone" value="{{ old('telephone') }}" autocomplete="off">
                                <button class="saveButton" type="submit">
                                    {{ __('保存') }}
                                </button>
                            </div>
                            @error('telephone')
                                <span class="error d-block text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
        </div>


        @can('boss')

        <div class="companyBox  d-flex flex-column align-items-center justify-content-center">
            <div class="title d-flex align-items-center mt-5">
                <img src="{{ asset('img/company-setting.svg') }}" alt="Company Setting Icon">
                <h2 class="m-0">会社情報</h2>
            </div>
            <div class="companyBoxInner  d-flex flex-column justify-content-center align-items-center mb-auto mt-auto">
                <form class="d-flex flex-column align-items-center justify-content-center" action="{{ route('profile.updateCompany', $company_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if (session('successCompany'))
                        <div class="success d-block text-center">
                            <strong>{{ session('successCompany') }}</strong>
                        </div>
                    @endif
                    <div class="companyNameBox">
                        <label for="companyName">{{ __('会社名') }}</label>
                        <div class="companyNameInput">
                            <input id="companyName" type="text"  name="companyName" value="{{ old('companyName') }}" autocomplete="companyName">
                            @error('companyName')
                                <span class="error d-block text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="companyPostCodeBox mx-auto">
                        <label class="d-block" for="companyPostCode">{{ __('会社の郵便番号') }}</label>
                        <div class="companyPostCodeInput">
                            <input id="companyPostCode" type="text" name="companyPostCode" value="{{ old('companyPostCode') }}" autocomplete="companyPostCode" >
                        </div>
                        @error('companyPostCode')
                            <span class="error d-flex justify-content-center" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="companyAddressBox">
                        <label for="companyAddress">{{ __('会社の住所') }}</label>
                        <div class="companyAddressInput">
                            <input id="companyAddress" type="text" name="companyAddress" value="{{ old('companyAddress') }}" autocomplete="companyAddress">
                            @error('companyAddress')
                                <span class="error d-block text-center" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="saveButton text-center">
                        <button type="submit">
                            {{ __('保存') }}
                        </button>
                    </div>
                </form>
            </div>
            @endcan
        </div>
    </div>
</div>
@endsection