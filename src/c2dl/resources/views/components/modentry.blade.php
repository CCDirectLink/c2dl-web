<ul class="mdl-list" id="mod-list">
    <li class="c2dl-list-entry">
          <div class="c2dl-entry">
              <div class="c2dl-chevron-right"></div>
              <div class="c2dl-entry-content">
                <span class="c2dl-entry-name">
                    <span class="c2dl-entry-title">{{ $data->metadata->getVisibleName() }}</span> – <span class="c2dl-entry-version">{{ $data->metadata->version }}</span>
                </span>
                  @if($data->metadata->hasReadableName())
                  <span class="c2dl-entry-codename">({{ $data->metadata->name }})</span>
                  @endif
                  <span class="c2dl-entry-description">{{ $data->metadata->description }}</span>
              </div>
          </div>
        <div class="c2dl-entry-links">
            @if($data->metadata->homepageType === 'github')
            <a class="c2dl-link-button c2dl-data-link c2dl-github"
               href="{{ $data->metadata->homepage }}" rel="noopener" target="_blank" title="GitHub ({{ $data->metadata->name }})">
                <div class="c2dl-link-icon c2dl-github-icon"></div>
            </a>
            @endif
            @if($data->metadata->homepageType === 'gitlab')
            <a class="c2dl-link-button c2dl-data-link c2dl-gitlab"
               href="{{ $data->metadata->homepage }}" rel="noopener" target="_blank" title="GitLab ({{ $data->metadata->name }})">
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
