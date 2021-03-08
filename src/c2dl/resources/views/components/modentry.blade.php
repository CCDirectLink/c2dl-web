@inject('svgController', 'App\Http\Controllers\SvgController')

<ul class="mdl-list" id="mod-list">
    <li class="c2dl-list-entry">
          <div class="c2dl-entry">
              {!! $svgController::provide([
                'name' => 'chevron_right',
                'class' => 'c2dl-chevron-right',
                'width' => '12.5px',
                'height' => '16px'
              ]) !!}
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
                {!! $svgController::provide([
                'name' => 'github_logo',
                'extern' => true,
                'class' => 'c2dl-link-icon c2dl-github-icon',
                'width' => '22px',
                'height' => '22px'
                ]) !!}
            </a>
            @endif
            @if($data->metadata->homepageType === 'gitlab')
            <a class="c2dl-link-button c2dl-data-link c2dl-gitlab"
               href="{{ $data->metadata->homepage }}" rel="noopener" target="_blank" title="GitLab ({{ $data->metadata->name }})">
                {!! $svgController::provide([
                'name' => 'gitlab_logo',
                'extern' => true,
                'class' => 'c2dl-link-icon c2dl-gitlab-icon',
                'width' => '22px',
                'height' => '22px'
                ]) !!}
            </a>
            @endif
            @isset($data->installation[0])
            <a class="c2dl-link-button c2dl-data-link c2dl-download" href="{{ $data->installation[0]->url }}" rel="noopener" target="_blank" title="Download ({{ $data->metadata->name }})">
                {!! $svgController::provide([
                'name' => 'download_icon',
                'class' => 'c2dl-link-icon c2dl-download-icon',
                'width' => '22px',
                'height' => '22px'
                ]) !!}
            </a>
            @endisset
          </div>
    </li>
</ul>
