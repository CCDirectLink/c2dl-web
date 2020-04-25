@inject('svgProvider', 'App\Http\Controllers\SvgProvider')

<ul class="mdl-list" id="mod-list">
    <li class="c2dl-list-entry">
          <div class="c2dl-entry">
              {!! $svgProvider::provide([
                'path' => 'chevron_right.svg',
                'class' => 'c2dl-chevron-right'
              ]) !!}
              <div class="c2dl-entry-content">
                <span class="c2dl-entry-name">
                    <span class="c2dl-entry-title">{{ $data->name }}</span> – <span class="c2dl-entry-version">{{ $data->last_version }}</span>
                </span>
                  <span class="c2dl-entry-description">{{ $data->description }}</span>
              </div>
          </div>
        <div class="c2dl-entry-links">
            @isset($data->version_list[$data->last_version]->page_list['GitHub'])
            <a class="c2dl-link-button c2dl-data-link c2dl-github"
               href="{{ $data->version_list[$data->last_version]->page_list['GitHub'] }}" rel="noopener" target="_blank" title="GitHub">
                {!! $svgProvider::provide([
                'path' => 'ext/github_logo.svg',
                'class' => 'c2dl-link-icon c2dl-github-icon'
                ]) !!}
            </a>
            @endisset
            @isset($data->version_list[$data->last_version]->page_list['GitLab'])
            <a class="c2dl-link-button c2dl-data-link c2dl-gitlab"
               href="{{ $data->version_list[$data->last_version]->page_list['GitLab'] }}" rel="noopener" target="_blank" title="GitLab">
                {!! $svgProvider::provide([
                'path' => 'ext/gitlab_logo.svg',
                'class' => 'c2dl-link-icon c2dl-gitlab-icon'
                ]) !!}
            </a>
            @endisset
            @isset($data->version_list[$data->last_version]->source_list[0])
            <a class="c2dl-link-button c2dl-data-link c2dl-download" href="{{ $data->version_list[$data->last_version]->source_list[0] }}" rel="noopener" target="_blank" title="Download">
                {!! $svgProvider::provide([
                'path' => 'download_icon.svg',
                'class' => 'c2dl-link-icon c2dl-download-icon'
                ]) !!}
            </a>
            @endisset
          </div>
    </li>
</ul>
