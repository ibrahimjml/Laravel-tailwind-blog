  <div  class="bg-[#0d1117] text-[#c9d1d9] font-mono text-xs p-4 rounded-xl h-[500px] overflow-y-auto space-y-2 border border-border">
      @forelse ($logs as $log)
        
      <div class="border-b border-white/5 pb-2">
        <span class="text-gray-500">{{ $log->created_at->format('[ d/m/y h:i:s ]') }}</span>
        <span class="text-yellow-500/70 ml-2">{{ '[' . $log->source->name . ']' }}</span>
        <span @class([
          'ml-2 uppercase font-bold',
          'text-red-500' => $log->level === 'error',
          'text-green-500' => $log->level === 'info',
          'text-blue-500' => $log->level === 'success',
          'text-yellow-500' => $log->level === 'warning',
        ])>{{ $log->level }}</span>
        <span class="ml-2">{{ $log->message }}</span></div>
      @empty
        <p>No Logs Yet.</p>
      @endforelse
    </div>
    <div id="logs-pagination" class="flex justify-center p-3">
    {{ $logs->links() }}
</div>