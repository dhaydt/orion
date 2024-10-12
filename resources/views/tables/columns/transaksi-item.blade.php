<div>
    @if ($getRecord()->transaksiProduk)
    @foreach ($getRecord()->transaksiProduk as $k => $p)
    <div style="--c-50:var(--success-50);--c-400:var(--success-400);--c-600:var(--success-600);"
        class="fi-badge flex items-center my-2 justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30">
        <!--[if BLOCK]><![endif]-->
        <!--[if BLOCK]><![endif]-->
        <!--[if ENDBLOCK]><![endif]-->

        <!--[if BLOCK]><![endif]-->
        <!--[if ENDBLOCK]><![endif]-->
        <!--[if ENDBLOCK]><![endif]-->

        <span class="grid">
            <span class="truncate">
                {{ $p->produk->nama ?? 'produk dihapus' }}
            </span>
        </span>

        <!--[if BLOCK]><![endif]-->
        <!--[if ENDBLOCK]><![endif]-->
    </div>
    @endforeach
    @endif
</div>
