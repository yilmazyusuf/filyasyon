<div class="btn-group">
    @foreach($buttons as $button => $properties)
        @if(empty($properties['required_permission']) || (isset($properties['required_permission'])   && $user->can($properties['required_permission'])))
            <a class="btn btn-sm btn-default" href="{{$properties['url']}}"
                    {{isset($properties['tooltip']) ? 'data-toggle=tooltip data-placement=top title='.$properties['tooltip'].'' : ''}}>
                <i class="fa {{$properties['icon_class']}}"></i></a>
        @endif
    @endforeach
</div>
