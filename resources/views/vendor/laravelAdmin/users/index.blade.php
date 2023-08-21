@extends('laravelAdmin::layouts.main')
@section('content')
  <x-laravelAdmin::content-wrapper>
    <div>
      @include('laravelAdmin::layouts.status')
      <div class="table-responsive">
        <table class="table hover striped">
          <thead>
            <tr>
              <th>名前</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>
                  {{ $user->name }}
                </td>
                <td>
                  <?php
                  $grants = array_unique(array_column($user->user_grants->toArray(), 'grant'));
                  ?>
                  <form action="{{ route('laravelAdmin.user.update', ['user' => $user->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <label>
                      <input type="checkbox" name="grant[]" value="0"<?= in_array(0, $grants) ? ' checked' : '' ?>>管理者
                    </label>
                    <button type="submit" class="btn btn-primary">変更</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mt-2">
        {{ $users->links() }}
      </div>
    </div>
  </x-laravelAdmin::content-wrapper>
@endsection
