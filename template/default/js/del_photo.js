function del_photo(photo_id) {
	$.post( '/wirtualnygaraz/usun/zdjecie', { id: photo_id } );
	var id_name = '#photo_'+photo_id;
	$( id_name ).remove();
}