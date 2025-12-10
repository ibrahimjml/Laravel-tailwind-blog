<div id="openModel" class="hidden fixed inset-0 z-30 bg-black bg-opacity-50 flex items-center justify-center p-4">

  <!-- Modal Content -->
  <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[90vh] flex flex-col">
    <!-- Modal Header -->
    <div class="flex justify-between items-center p-4 border-b border-gray-200">
      <h2 class="text-xl font-bold text-gray-800">Edit post <b id="title"></b></h2>
      <button id="closeModel" class="text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fas fa-times fa-lg"></i>
      </button>
    </div>
    <!-- Modal body -->
  <div class="p-6 overflow-y-auto">
 <form id="editpost" method="POST" class="space-y-6">
 @csrf
 @method("PUT")
   <!-- Form Fields -->
        
<label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status:</label>      
<select name="status" id="status" class="pl-3 w-36 appearance-none font-bold cursor-pointer border-2 text-blueGray-500  text-sm rounded-lg p-2.5">
@foreach (\App\Enums\PostStatus::cases() as $status )
<option value="{{$status->value}}">{{$status->name}}</option>
@endforeach  
</select>     
  <!-- Modal Footer -->
        <div class="flex justify-end items-center pt-4">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Edit
            </button>
        </div>    
</form> 
</div>
</div>
</div>