<button {{ $attributes->merge([
    'type' => 'submit', 
    'class' => 'inline-flex items-center px-4 py-2 bg-[#000066] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#000080] hover:scale-105 focus:bg-[#000080] active:bg-[#00004d] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200'
    ]) }}>
    {{ $slot }}
</button>
