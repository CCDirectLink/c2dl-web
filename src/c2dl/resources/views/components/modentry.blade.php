<ul class="mdl-list" id="mod-list">
    <li class="c2dl-list-entry">
          <div class="c2dl-entry">
              <div class="c2dl-chevron-right"></div>
              <div class="c2dl-entry-content">
                  <span class="c2dl-entry-name">
                      <span class="c2dl-entry-title">{{ $data->metadata->getVisibleName() }}</span>
                      (<span class="c2dl-entry-version">{{ $data->metadata->version }})</span>
                      by <span class="c2dl-entry-authors">{{ $data->metadata->authors }}</span>
                      (⭐<span class="c2dl-entry-stars">{{ $data->metadata->stars }}</span>)
                  </span>
                  @if($data->metadata->hasReadableName())
                  <span class="c2dl-entry-codename">({{ $data->metadata->name }})</span>
                  @endif
                  <span class="c2dl-entry-description">{{ $data->metadata->description }}</span>
                  @if($data->metadata->tags)
                  <span class="c2dl-entry-tags">Tags: {{ $data->metadata->tags}}</span>
                  @endif
              </div>
          </div>
        <div class="c2dl-entry-links">
            @isset($data->metadata->homepage)
            <a class="c2dl-link-button c2dl-data-link c2dl-homepage"
               href="{{ $data->metadata->homepage }}" rel="noopener" target="_blank" title="Homepage ({{ $data->metadata->name }})">
                <div class="c2dl-link-icon c2dl-homepage-icon"></div>
            </a>
            @endisset
            @if($data->metadata->repositoryType === 'github')
            <a class="c2dl-link-button c2dl-data-link c2dl-github"
               href="{{ $data->metadata->repository }}" rel="noopener" target="_blank" title="GitHub ({{ $data->metadata->name }})">
                <div class="c2dl-link-icon c2dl-github-icon"></div>
            </a>
            @endif
            @if($data->metadata->repositoryType === 'gitlab')
            <a class="c2dl-link-button c2dl-data-link c2dl-gitlab"
               href="{{ $data->metadata->repository }}" rel="noopener" target="_blank" title="GitLab ({{ $data->metadata->name }})">
                <div class="c2dl-link-icon c2dl-gitlab-icon"></div>
            </a>
            @endif
            @isset($data->installation[0])
            <a class="c2dl-link-button c2dl-data-link c2dl-download" href="{{ $data->installation[0]->url }}" rel="noopener" target="_blank" title="Download ({{ $data->metadata->name }})">
                <div class="c2dl-link-icon c2dl-download-icon"></div>
            </a>
            @endisset
          </div>
    </li>
</ul>
