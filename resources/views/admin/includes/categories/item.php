<tr>
    <td>
        #
    </td>
    <td>
        <a>
            {{cat_name}}
        </a>
        <br />
        <small>
            {{cat_date}}
        </small>
    </td>
    <td>
        <ul class="list-inline">
            <li class="list-inline-item">
                <img alt="image" class="table-avatar imagem-categorie" src="{{cat_img}}">
            </li>
        </ul>
    </td>
    <td>
        <a>
            {{cat_description}}
        </a>
    </td>
    <td class="project-actions text-right">
        <a class="btn btn-info btn-sm" href="{{URL}}/dashboard/categories/{{cat_id}}/edit">
            <i class="fas fa-pencil-alt">
            </i>
            Edit
        </a>
        <a class="btn btn-danger btn-sm" href="{{URL}}/dashboard/categories/{{cat_id}}/delete">
            <i class="fas fa-trash">
            </i>
            Delete
        </a>
    </td>
</tr>