

<div class="md:flex flex-col md:flex-row sidebar md:min-h-screen">
    <div @click.away="open = false" class="flex flex-col w-full md:w-72 text-gray-700 dark-mode:text-gray-200 dark-mode:bg-gray-800 flex-shrink-0" x-data="{ open: false }">
      <div class="flex-shrink-0 px-8 py-4 flex flex-row items-center justify-between h-10">
        <a href="#" class="text-lg font-semibold tracking-widest text-white uppercase rounded-lg focus:outline-none focus:shadow-outline"></a>
        <button class="rounded-lg md:hidden focus:outline-none focus:shadow-outline" @click="open = !open">
          <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
            <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
            <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <nav :class="{'block': open, 'hidden': !open}" class="flex-grow md:block px-0 pb-4 md:pb-0 md:overflow-y-auto">

        <a class="@if(request()->routeIs('users.index')) {{ 'active' }} @endif" href="{{ route('users.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Usuários
        </a>

        <a class="@if(request()->routeIs('occupations.index')) {{ 'active' }} @endif" href="{{ route('occupations.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Cargos
        </a>

        <a class="@if(request()->routeIs('departments.index')) {{ 'active' }} @endif" href="{{ route('departments.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Departamentos
        </a>

        <a class="@if(request()->routeIs('customers.index')) {{ 'active' }} @endif" href="{{ route('customers.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Clientes
        </a>

        <a class="@if(request()->routeIs('project.index')) {{ 'active' }} @endif" href="{{ route('project.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            Projetos
        </a>

        <a class="@if(request()->routeIs('sample-analysis.index')) {{ 'active' }} @endif" href="{{ route('sample-analysis.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
            </svg>
            Analise de Amostras
        </a>
        <div class="relative" x-data="{ openConfig: {{ request()->routeIs('config.emails.*') ? 'true' : 'false' }} }">
          <button @click="openConfig = !openConfig" class="submenu">
            <svg xmlns="http://www.w3.org/2000/svg" class="inline h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
            </svg>
            <span>E-mail</span>
            <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': openConfig, 'rotate-0': !openConfig}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
          </button>
          <div x-show="openConfig" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
            <div class="px-0 py-0 ">
                <a class="@if(request()->routeIs('config.emails.index')) {{ 'active' }} @endif" href="{{ route('config.emails.index') }}">Configurações</a>
            </div>
            <div class="px-0 py-0 ">
                <a class="@if(request()->routeIs('config.emails.templates.index')) {{ 'active' }} @endif" href="{{ route('config.emails.templates.index') }}">Templates</a>
            </div>
          </div>
        </div>

        <div class="relative" x-data="{ openRegisters: {{ request()->routeIs('registers.*') ? 'true' : 'false' }} }">
            <button @click="openRegisters = !openRegisters" class="submenu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
              <span>Cadastros</span>
              <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': openRegisters, 'rotate-0': !openRegisters}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <div x-show="openRegisters" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.parameter-method.index')) {{ 'active' }} @endif" href="{{ route('registers.parameter-method.index') }}">Método/Prazo</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.preparation-method.index')) {{ 'active' }} @endif" href="{{ route('registers.preparation-method.index') }}">Método</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('parameter-analysis.index')) {{ 'active' }} @endif" href="{{ route('parameter-analysis.index') }}">Param. Análise</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('guiding-parameter.index')) {{ 'active' }} @endif" href="{{ route('guiding-parameter.index') }}">Param. Orientador Ambiental</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('guiding-parameter-ref-value.index')) {{ 'active' }} @endif" href="{{ route('guiding-parameter-ref-value.index') }}">Ref. Vlr. Param. Orientador</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('guiding-parameter-value.index')) {{ 'active' }} @endif" href="{{ route('guiding-parameter-value.index') }}">Valor Param. Orientador</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.geodetics.index')) {{ 'active' }} @endif" href="{{ route('registers.geodetics.index') }}">Tipo Sistema Geodésico</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.environmental-area.index')) {{ 'active' }} @endif" href="{{ route('registers.environmental-area.index') }}">Tipo Área Ambiental</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.plan-action-level.index')) {{ 'active' }} @endif" href="{{ route('registers.plan-action-level.index') }}">Tipo Nível Ação Plano</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.guiding-value.index')) {{ 'active' }} @endif" href="{{ route('registers.guiding-value.index') }}">Tipo Valor Orientador</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.environmental-agency.index')) {{ 'active' }} @endif" href="{{ route('registers.environmental-agency.index') }}">Órgão Ambiental</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.analysis-parameter.index')) {{ 'active' }} @endif" href="{{ route('registers.analysis-parameter.index') }}">Tipo Param. Análise</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.point-identification.index')) {{ 'active' }} @endif" href="{{ route('registers.point-identification.index') }}">Ponto</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.parameter-analysis-group.index')) {{ 'active' }} @endif" href="{{ route('registers.parameter-analysis-group.index') }}">Grupo Param. Análise</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.campaign-status.index')) {{ 'active' }} @endif" href="{{ route('registers.campaign-status.index') }}">Status Campanha</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.analysis-matrix.index')) {{ 'active' }} @endif" href="{{ route('registers.analysis-matrix.index') }}">Matriz Análise</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.unity.index')) {{ 'active' }} @endif" href="{{ route('registers.unity.index') }}">Unidade</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.calculation-parameter.index')) {{ 'active' }} @endif" href="{{ route('registers.calculation-parameter.index') }}">Param. Fórmula Cálculo</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.calculation-variable.index')) {{ 'active' }} @endif" href="{{ route('registers.calculation-variable.index') }}">Variável Fórmula Cálculo</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.lab.index')) {{ 'active' }} @endif" href="{{ route('registers.lab.index') }}">Laboratório</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('registers.replace.index')) {{ 'active' }} @endif" href="{{ route('registers.replace.index') }}">De Para</a>
                </div>
            </div>
        </div>

        <div class="relative" x-data="{ openRegisters: {{ request()->routeIs('fields.*') ? 'true' : 'false' }} }">
            <button @click="openRegisters = !openRegisters" class="submenu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                </svg>
              <span>Registros de Campo</span>
              <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': openRegisters, 'rotate-0': !openRegisters}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform md:-mt-1 text-white"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
            <div x-show="openRegisters" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="relative right-0 w-full origin-top-right">
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('fields.form.index')) {{ 'active' }} @endif" href="{{ route('fields.form.index') }}">Formulários</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('fields.ref.index')) {{ 'active' }} @endif" href="{{ route('fields.ref.index') }}">Referências</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('fields.form-values.index')) {{ 'active' }} @endif" href="{{ route('fields.form-values.index') }}">Formulários Preenchidos</a>
                </div>
                <div class="px-0 py-0 ">
                    <a class="@if(request()->routeIs('fields.config.index')) {{ 'active' }} @endif" href="{{ route('fields.config.index') }}">Configurações</a>
                </div>
            </div>
        </div>
      </nav>
    </div>
  </div>
