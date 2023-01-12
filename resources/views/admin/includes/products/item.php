<tr>
    <td>
        #
    </td>
    <td>
        <a>
            {{p_name}}
        </a>
        <br />
        <small>
            {{p_date}}
        </small>
    </td>
    <td>
        <ul class="list-inline">
            <li class="list-inline-item">
                <img alt="image" class="table-avatar imagem-produto" src="{{p_img}}">
            </li>
        </ul>
    </td>
    <td>
        <a>
            R$ {{p_price}}
        </a>
    </td>
    <td>
        <div style="text-align: center;">
            <a>
                R$ {{p_dis_price}}
            </a>
        </div>
    </td>
    <td>

        <a href="{{URL}}/dashboard/{{cat_link}}" class="card-link">
            <div class="card categorie-card">
                <div class="card-body">
                    <img class="rounded-circle imagem-categorie" src="{{cat_img}}" alt="image">
                    <p>{{cat_name}}</p>
                </div>
            </div>
        </a>
    </td>
    <td>
        <a>
            {{p_desc}}
        </a>
    </td>
    <td class="project-actions text-right">
        <a class="btn btn-info btn-sm" href="{{URL}}/dashboard/products/{{p_id}}/edit">
            <i class="fas fa-pencil-alt">
            </i>
            Edit
        </a>
        <a class="btn btn-danger btn-sm toastrDeletedSuccess" href="{{URL}}/dashboard/products/{{p_id}}/delete">
            <i class="fas fa-trash">
            </i>
            Delete
        </a>
    </td>
</tr>