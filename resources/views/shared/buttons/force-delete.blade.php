<form action="{{ $action }}" onsubmit="return confirm('Your data qill be removed permanently')" method="POST"
    style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-circle btn-outline-danger" title="Delete permanently"><i
            class="fa fa-times"></i>
    </button>
</form>
