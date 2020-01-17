<ul class="mdl-list" id="mod-list">
    <li class="c2dl-list-entry">
          <div class="c2dl-entry">
            <i class="c2dl-chevron-right"></i>
              <div class="c2dl-entry-content">
                <span class="c2dl-entry-name">
                    <span class="c2dl-entry-title">{{ $data->name }}</span> – <span class="c2dl-entry-version">{{ $data->last_version }}</span>
                </span>
                  <span class="c2dl-entry-description">{{ $data->description }}</span>
              </div>
          </div>
        <div class="c2dl-entry-links">
            @isset($data->version_list[$data->last_version]->page_list['GitHub'])
            <a class="c2dl-data-link c2dl-github"
               href="{{ $data->version_list[$data->last_version]->page_list['GitHub'] }}" rel="noopener" target="_blank" title="GitHub">
                <i class="c2dl-link-icon c2dl-github-icon"></i></a>
            @endisset
            @isset($data->version_list[$data->last_version]->page_list['GitLab'])
            <a class="c2dl-data-link c2dl-gitlab"
               href="{{ $data->version_list[$data->last_version]->page_list['GitLab'] }}" rel="noopener" target="_blank" title="GitLab">
                <i class="c2dl-link-icon c2dl-gitlab-icon"></i></a>
            @endisset
            <a class="c2dl-data-link c2dl-download" href="{{ $data->version_list[$data->last_version]->source_list[0] }}" rel="noopener" target="_blank" title="Download">
                <i class="c2dl-link-icon c2dl-download-icon"></i></a>
          </div>
    </li>
</ul>
