<tr>
    <td>
        #
    </td>
    <td>
        <a>
            {{name}}
        </a>
        <br />
        <small>
            {{date}}
        </small>
    </td>
    <td>
        <ul class="list-inline">
            <li class="list-inline-item">
                <img alt="image" class="table-avatar imagem-categorie" src="{{img}}">
            </li>
        </ul>
    </td>
    <td>
        <a>
            {{description}}
        </a>
    </td>
    <td class="project-actions text-right">
        <a class="btn btn-info btn-sm" href="{{URL}}/dashboard/categories/{{id}}/edit">
            <i class="fas fa-pencil-alt">
            </i>
            Edit
        </a>
        <a class="btn btn-danger btn-sm toastrDeletedSuccess" href="">
            <i class="fas fa-trash">
            </i>
            Delete
        </a>
    </td>
</tr>