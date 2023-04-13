<tr>
    <td colspan="{{ $numCol }}">
        .<div class="alert alert-danger" role="alert">
            @isset($message)
                {{ $message }}
            @else
                No record found
            @endisset
        </div>

    </td>
</tr>
