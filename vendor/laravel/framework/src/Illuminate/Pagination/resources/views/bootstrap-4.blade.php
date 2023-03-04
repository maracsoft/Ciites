{{-- Modificado por juguito --}}

@php
  $pagination_row_from = $paginator->perPage() * ($paginator->currentPage() - 1) + 1;
  $pagination_row_to = $pagination_row_from + $paginator->perPage() - 1;
  
  if($pagination_row_to > $paginator->total())
    $pagination_row_to = $paginator->total()
@endphp
@if ($paginator->hasPages())
    <nav> 
        <ul class="pagination">
          {{-- Previous Page Link --}}
          @if ($paginator->onFirstPage())
              <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                  <span class="page-link" aria-hidden="true">&lsaquo;</span>
              </li>
          @else
              <li class="page-item">
                  <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
              </li>
          @endif

          {{-- Pagination Elements --}}
          @foreach ($elements as $element)
              {{-- "Three Dots" Separator --}}
              @if (is_string($element))
                  <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
              @endif

              {{-- Array Of Links --}}
              @if (is_array($element))
                  @foreach ($element as $page => $url)
                      @if ($page == $paginator->currentPage())
                          <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                      @else
                          <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                      @endif
                  @endforeach
              @endif
          @endforeach

          {{-- Next Page Link --}}
          @if ($paginator->hasMorePages())
              <li class="page-item">
                  <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
              </li>
          @else
              <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                  <span class="page-link" aria-hidden="true">&rsaquo;</span>
              </li>
          @endif
          {{--  {{dd($paginator)}} --}}
            
          <li class="ml-auto rows_count d-none d-md-block">
            Mostrando registros 
            (<span>
              {{$pagination_row_from}}
            </span>
            al
            <span>
              {{$pagination_row_to}}
            </span>)
            
            de un total de
            <span>
              {{$paginator->total()}}
            </span> 
          </li>  
          
        </ul>
        
    </nav>
    

    <div class="ml-auto rows_count d-block d-md-none">
      Mostrando registros 
      (<span>
        {{$pagination_row_from}}
      </span>
      al
      <span>
        {{$pagination_row_to}}
      </span>)
      
      de un total de
      <span>
        {{$paginator->total()}}
      </span> 
    </div>  


 
@endif
<style>


</style>