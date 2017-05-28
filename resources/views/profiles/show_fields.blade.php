<div class="row">
    <div class="col-md-6">

        <!-- Profile Image -->
        <div class="box box-primary">
            <li class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="https://scontent.fdad2-1.fna.fbcdn.net/v/t1.0-1/c29.0.100.100/p100x100/10354686_10150004552801856_220367501106153455_n.jpg?oh=84747009adeef1b5552a06af38a9fca8&oe=598C2177" alt="User profile picture">

                <h3 class="profile-username text-center">{!! $user->name !!}</h3>

                <p class="text-muted text-center">
                    @if(!empty($user->roles))
                        @foreach($user->roles as $v)
                            <label class="label label-success">{{ $v->display_name }}</label>
                        @endforeach
                    @endif
                </p>

                <ul class="list-group list-group-unbordered">
                    @if(isset($profile->full_name))
                        <li class="list-group-item">
                            <b>{!! Form::label('full_name', __('users.label_full_name')) !!}</b>
                            <a class="pull-right">{!! $profile->full_name !!}</a>
                        </li>
                    @endif
                    @if(isset($profile->full_name))
                        <li class="list-group-item">
                            <b>{!! Form::label('full_name', __('users.label_birthday')) !!}</b>
                            <a class="pull-right">{!! $profile->birthday !!}</a>
                        </li>
                    @endif
                    @if(isset($profile->full_name))
                        <li class="list-group-item">
                            <b>{!! Form::label('full_name', __('users.label_phone_number')) !!}</b>
                            <a class="pull-right">{!! $profile->phone_number !!}</a>
                        </li>
                    @endif
                    @if(isset($profile->address))
                        <li class="list-group-item">
                            <b>{!! Form::label('full_name', __('users.label_address')) !!}</b>
                            <a class="pull-right">{!! $profile->address !!}</a>
                        </li>
                    @endif
                </ul>
                <a href="{!! route('profiles.edit') !!}" class="btn btn-primary btn-block"><b>@lang('buttons.btn_edit')</b></a>
            </li>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>