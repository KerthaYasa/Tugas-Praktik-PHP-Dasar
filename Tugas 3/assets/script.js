// assets/script.js — AJAX search (pakai search.php)
$(function(){
  const $input = $('#search');
  const $tbody = $('#table-body');
  let timer = null;

  function doSearch(q){
    $.get('search.php', { keyword: q })
      .done(function(html){
        $tbody.html(html);
      })
      .fail(function(xhr, status, err){
        console.error('AJAX Error:', status, err);
        $tbody.html('<tr><td colspan="5">Terjadi kesalahan saat memuat data.</td></tr>');
      });
  }

  // jalankan pencarian pertama (semua data)
  doSearch('');

  $input.on('input', function(){
    clearTimeout(timer);
    const q = $(this).val();
    timer = setTimeout(() => doSearch(q), 250); // debounce 250ms
  });
});
