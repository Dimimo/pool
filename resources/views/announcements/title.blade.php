@switch($cycle)
    @case('2021/01')
        @include('pool::announcements._title-2021-01')
        @break

    @case('2021/04')
        @include('pool::announcements._title-2021-04')
        @break

    @case('2021/05')
        @include('pool::announcements._title-2021-05')
        @break

    @case('2021/07')
        @include('pool::announcements._title-2021-07')
        @break

    @case('2021/08')
        @include('pool::announcements._title-2021-08')
        @break

    @case('2021/10')
        @include('pool::announcements._title-2021-10')
        @break

    @case('2021/11')
        @include('pool::announcements._title-2021-11')
        @break

    @case('2022/01')
        @include('pool::announcements._title-2022-01')
        @break

    @case('2022/03')
        @include('pool::announcements._title-2022-03')
        @break

    @case('2022/05')
        @include('pool::announcements._title-2022-05')
        @break

    @case('2022/08')
        @include('pool::announcements._title-2022-08')
        @break

    @case('2022/10')
        @include('pool::announcements._title-2022-10')
        @break

    @case('2022/10')
        @include('pool::announcements._title-2023-01')
        @break

    @default
        @include('pool::announcements._title-default')
@endswitch
