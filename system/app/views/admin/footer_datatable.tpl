<script src="/assets/common/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/assets/common/vendor/datatables_plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

<script>
    $(document).ready( function() {  
		 {if $list}$('#transaction').dataTable({
        	"order": [[ 0, "desc" ]]
    	});{/if} 

    });
</script>