        <h3 class="azul">Administração do sistema de Portarias</h3>
        <p>Olá, <?php echo $_SESSION['usuNome']; ?></p>
        <nav class="navbar navbar-expand-lg navbar-dark fundo-azul">
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link text-white" href="index.php?action=inicio&control=administracao">Início</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=usuarios&control=usuario">Usuários</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=unidades&control=unidade">Unidades</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=portarias&control=portaria">Portarias</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=crachas&control=cracha">Crachás</a>
                    <span class="nav-link text-white">|</span>
                    <a class="nav-link text-white" href="index.php?action=logout">Sair</a>
                </div>
            </div>
        </nav>
        <br>
        <h4><?php echo $titulo; ?></h4>