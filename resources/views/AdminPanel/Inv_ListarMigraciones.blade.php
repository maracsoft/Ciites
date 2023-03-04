 
    <table class="table table-bordered table-hover datatable table-sm" id="table-3">
      <thead>                  
        <tr>
          <th>
            Archivo
          </th>
          <th>
            ¿En DB?
          </th>
          <th>version</th>
          <th>Nombre</th>
          <th>Inicio</th>
          <th>Fin</th>
          <th>breakpoint</th>
          
          
        </tr >
      </thead>
      <tbody>
        @foreach ($migrationList as $migracion)
        @php
          $finded = $migracion['finded'];
          $migration_db = $migracion['migration_db'];
        @endphp
          <tr>
            <td>
              {{$migracion['filename']}}
            </td>
            <td>
              @if($finded)
                SÍ
              @else
                NO
              @endif
            </td>
            @if($finded)
              <td>
                {{$migration_db->version}}
              </td>
              <td>
                {{$migration_db->migration_name}}
              </td>
              <td>
                {{$migration_db->getStartTime()}}
              </td>
              <td>
                {{$migration_db->getEndTime()}}
              </td>
              <td>
                {{$migration_db->breakpoint}}
              </td>
            @else
              <td colspan="5">

              </td>
              
            @endif

            

          </tr>
        @endforeach
      </tbody>
    </table>