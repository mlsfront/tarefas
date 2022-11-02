    <!--inicioNavbar-->
    <nav class="navbar navbar-expand-lg bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="images/favicon.ico"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php"><i class="fa-solid fa-table-list"></i></a>  
            </li>
            <li class="nav-item">
              <a class="nav-link" href="situacao.php"><i class="fa-solid fa-charging-station"></i></a> 
            </li>
            <li class="nav-item">
              <a class="nav-link" href="modalidade.php"><i class="fa-solid fa-list"></i></a> 
            </li>
            <li class="nav-item">
              <a class="nav-link" href="https://mlsfront.github.io/alarme/" target="_blank"><i class="fa-regular fa-clock"></i></a>    
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Opções
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="index.php"><i class="fa-solid fa-table-list"></i> Listar Tarefas</a></li>
                <li><a class="dropdown-item" href="cadastrar.php"><i class="fa-regular fa-square-plus"></i> Cadastrar Tarefa</a></li>
                <li><a class="dropdown-item" href="situacao.php"><i class="fa-solid fa-charging-station"></i> listar Situações</a></li>
                <li><a class="dropdown-item" href="cadsit.php"><i class="fa-regular fa-square-plus"></i> Cadastrar Situação</a></li>
                <li><a class="dropdown-item" href="modalidade.php"><i class="fa-solid fa-list"></i> Listar Modalidades</a></li>
                <li><a class="dropdown-item" href="cadmod.php"><i class="fa-regular fa-square-plus"></i> Cadastrar Modalidade</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item disabled" href="#">Aguardando Conteúdo</a></li>
              </ul>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link disabled">Disabled</a>
            </li> -->
          </ul>
          <form class="d-flex" role="search" method="POST" action="pesquisar.php">
            <!--<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
            <button class="btn btn-outline-success" type="submit">Situação</button>
          </form>
        </div>
      </div>
    </nav>