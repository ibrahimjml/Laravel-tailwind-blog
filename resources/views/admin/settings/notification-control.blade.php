@extends('admin.partials.layout')
@section('title', 'notification control | Dashboard')
@section('content')
  <!-- Header -->
  @include('admin.partials.header', ['linktext' => 'Notification Control', 'route' => 'admin.settings.index', 'value' => request('search')])

  <div class="md:ml-64 w-full mx-auto transform -translate-y-48">
    <div class="flex flex-col">
      <div class="w-full lg:w-8/12 px-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
          <div class="rounded-t bg-white mb-0 px-6 py-6">
            <div class="text-center flex justify-between">
              <h6 class="text-blueGray-700 text-xl font-bold">
                Manage Notifications
              </h6>

            </div>
          </div>
          <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
              Get whether Notified
            </h6>
            <form action="{{ route('admin.settings.notification.toggle') }}" method="POST">
              @csrf
              @method('PATCH')
              <div class="flex flex-col">
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                       name="notifications[{{ \App\Enums\NotificationType::LIKE->value }}]"
                       :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::LIKE->value] ?? false"
                      label="{{\App\Enums\NotificationType::LIKE->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when someone likes on post.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                      name="notifications[{{ \App\Enums\NotificationType::POSTCREATED->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::POSTCREATED->value] ?? false"
                      label="{{\App\Enums\NotificationType::POSTCREATED->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when someone likes on post.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                      name="notifications[{{ \App\Enums\NotificationType::COMMENTS->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::COMMENTS->value] ?? false"
                      label="{{\App\Enums\NotificationType::COMMENTS->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when someone commented or replied on post.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                      name="notifications[{{ \App\Enums\NotificationType::REPORT->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::REPORT->value] ?? false"
                      label="{{\App\Enums\NotificationType::REPORT->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when report has been made in post, profile or
                      comment.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle
                      name="notifications[{{ \App\Enums\NotificationType::FOLLOW->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::FOLLOW->value] ?? false"
                      label="{{\App\Enums\NotificationType::FOLLOW->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when someone requested to follow.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                      name="notifications[{{ \App\Enums\NotificationType::FOLLOWACCEPT->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::FOLLOWACCEPT->value] ?? false"
                      label="{{\App\Enums\NotificationType::FOLLOWACCEPT->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when someone accept follows requests.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                      name="notifications[{{ \App\Enums\NotificationType::VIEWEDPROFILE->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::VIEWEDPROFILE->value] ?? false"
                      label="{{\App\Enums\NotificationType::VIEWEDPROFILE->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when someone viewed user profile.</p>
                  </div>
                </div>
                <div class="w-full px-4">
                  <div class="relative w-full mb-3">
                    <x-toggle 
                      name="notifications[{{ \App\Enums\NotificationType::NEWUSER->value }}]"
                      :disabled="! auth()->user()->can('notifications.update')"
                      :checked="$setting[\App\Enums\NotificationType::NEWUSER->value] ?? false"
                      label="{{\App\Enums\NotificationType::NEWUSER->label()}}" />
                    <p class="mt-1 text-xs text-blueGray-400"> get notified when a new user join platform.</p>
                  </div>
                </div>
              </div>
               <div class="flex justify-end mt-6">
                @can('notifications.update')
                    <button class="bg-green-500 text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150" type="submit">
                        Save Changes
                    </button>
                    @endcan
                </div>
            </form>
          </div>

        </div>

      </div>
@endsection