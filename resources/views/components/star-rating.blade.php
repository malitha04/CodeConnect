@props(['rating', 'size' => 'text-sm', 'showText' => false])

<div class="flex items-center space-x-1">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $rating)
            <i class="fas fa-star text-yellow-400 {{ $size }}"></i>
        @else
            <i class="far fa-star text-gray-300 {{ $size }}"></i>
        @endif
    @endfor
    @if($showText)
        <span class="ml-2 text-sm text-text-secondary">
            @switch($rating)
                @case(1)
                    Poor
                    @break
                @case(2)
                    Fair
                    @break
                @case(3)
                    Good
                    @break
                @case(4)
                    Very Good
                    @break
                @case(5)
                    Excellent
                    @break
                @default
                    Not Rated
            @endswitch
        </span>
    @endif
</div>
