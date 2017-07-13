    
<?php
/* echo "<pre>";       
  var_dump($this->getItem());
  echo "</pre>";die(); */
foreach ($this->getItem() as $modal) {
    ?>
    <div class="ui modal" id='modal<?php echo $modal->getId() ?>'>
        <i class="close icon"></i>
        <div class="header">
            Detalhes do Imóvel
        </div>
        <div class="content">
            <div class="description">
                <?php
                
                //verificar se a descrição está preenchida, pois é um campo não obrigatório
                if (trim($modal->getIdentificacao()) == "") {
                    $descricao = "<h4 class='ui red header'>Não Informado</h4>";
                } else {
                    $descricao = $modal->getIdentificacao();
                }

                echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Tipo</div>
                                    " . $modal->buscarTipoImovel($modal->getIdTipoImovel()) . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Descrição</div>
                                    " . $descricao . "
                                  </div>
                                </div>
                            </div>
                            <div class='ui hidden divider'></div>";

                switch ($modal->getIdTipoImovel()) {
                    case "1":

                        echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condição</div>
                                    " . ucfirst($modal->getCondicao()) . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Quarto(s)</div>
                                    " . $modal->getCasa()->getQuarto() . "
                                  </div>
                                </div>                                
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Banheiro(s)</div>
                                    " . $modal->getCasa()->getBanheiro() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Suite(s)</div>
                                    " . $modal->getCasa()->getSuite() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Vagas de Garagem</div>
                                    " . $modal->getCasa()->getGaragem() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    " . $modal->getCasa()->getArea() . "
                                  </div>
                                </div>                                
                            </div>";
                        break;

                    case "2":

                        echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Número de Andares</div>
                                    " . $modal->getApartamentoPlanta()->getAndares() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Unidades por Andar</div>
                                    " . $modal->getApartamentoPlanta()->getUnidadesAndar() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Número de Torres</div>
                                    " . $modal->getApartamentoPlanta()->getNumeroTorres() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Total de Unidades</div>
                                    " . $modal->getApartamentoPlanta()->getTotalUnidades() . "
                                  </div>
                                </div>                              
                            </div>";

                        $numeroPlantas = count($modal->getPlanta());

                        if ($numeroPlantas == 1) {

                            echo "<div class='ui hidden divider'></div>                                   
                                <div class='ui horizontal list'>
                                    <div class='item'>
                                      <div class='content'>
                                        <div class='header'>Total de Plantas</div>
                                        " . $numeroPlantas . "
                                      </div>
                                    </div>
                                </div>
                                
                                <table class='ui table'>
                                <thead>
                                    <tr>
                                        <th>Titulo da Planta</th>
                                        <th>Quarto(s)</th>
                                        <th>Banheiro(s)</th>
                                        <th>Suite(s)</th>
                                        <th>Vaga(s) de Garagem</th>
                                        <th>Área m<SUP>2</SUP></th>
                                        <th>Diferencial da Planta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>";


                            foreach ($modal->getPlanta() as $valoresPlanta) {
                                echo "<td>" . $valoresPlanta->getTituloPlanta() . "</td>";
                                echo "<td>" . $valoresPlanta->getQuarto() . "</td>";
                                echo "<td>" . $valoresPlanta->getBanheiro() . "</td>";
                                echo "<td>" . $valoresPlanta->getSuite() . "</td>";
                                echo "<td>" . $valoresPlanta->getGaragem() . "</td>";
                                echo "<td>" . $valoresPlanta->getArea() . "</td>";
                            }

                            echo "</tr></tbody></table>";
                        } else {


                            echo "<div class='ui hidden divider'></div>                                   
                                    <div class='ui horizontal list'>
                                      <div class='item'>
                                      <div class='content'>
                                        <div class='header'>Total de Plantas</div>
                                        " . $numeroPlantas . "
                                      </div>
                                    </div>
                                </div>
                                <table class='ui table'>
                                <thead>
                                    <tr>
                                        <th>Titulo da Planta</th>
                                        <th>Quarto(s)</th>
                                        <th>Banheiro(s)</th>
                                        <th>Suite(s)</th>
                                        <th>Vaga(s) de Garagem</th>
                                        <th>Área m<SUP>2</SUP></th>
                                    </tr>
                                </thead>
                                <tbody>";


                            $plantasOrdenadas = $modal->getPlanta();
                            //ordenar as plantas pelo ID
                            usort($plantasOrdenadas, function( $a, $b ) {
                                //ID da planta será usado para comparação
                                return ( $a->getId() > $b->getId() );
                            });
                            //fim da ordenação

                            foreach ($plantasOrdenadas as $valoresPlanta) {
                                echo "<tr>";
                                echo "<td>" . $valoresPlanta->getTituloPlanta() . "</td>";
                                echo "<td>" . $valoresPlanta->getQuarto() . "</td>";
                                echo "<td>" . $valoresPlanta->getBanheiro() . "</td>";
                                echo "<td>" . $valoresPlanta->getSuite() . "</td>";
                                echo "<td>" . $valoresPlanta->getGaragem() . "</td>";
                                echo "<td>" . $valoresPlanta->getArea() . "</td>";
                            }
                            echo "</tr></tbody></table>";
                        }

                        break;
                    case "3":
                        if ($modal->getApartamento()->getCondominio() != "" || $modal->getApartamento()->getCondominio() != 0) {
                            $condominio = $modal->getApartamento()->getCondominio();
                        } else
                            $condominio = "<h4 class='ui red header'>Não Informado</h4></div>";
                        echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condição</div>
                                    " . ucfirst($modal->getCondicao()) . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Quarto(s)</div>
                                    " . $modal->getApartamento()->getQuarto() . "
                                  </div>
                                </div>                               
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Banheiro(s)</div>
                                    " . $modal->getApartamento()->getBanheiro() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Suite(s)</div>
                                    " . $modal->getApartamento()->getSuite() . "
                                  </div>
                                </div> 
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Vagas de Garagem</div>
                                    " . $modal->getApartamento()->getGaragem() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Andar do Apartamento</div>
                                    " . $modal->getApartamento()->getAndar() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Apartamentos por Andar</div>
                                    " . $modal->getApartamento()->getUnidadesAndar() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    " . $modal->getApartamento()->getArea() . "
                                  </div>
                                </div>
                            </div>
                            <div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condomínio</div>
                                    R$ " . $condominio . "
                                  </div>
                                </div>
                            </div>";
                        break;

                    case "4":


                        echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condição</div>
                                    " . ucfirst($modal->getCondicao()) . "
                                  </div>
                                </div>                                                               
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Banheiro(s)</div>
                                    " . $modal->getSalaComercial()->getBanheiro() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Vagas de Garagem</div>
                                    " . $modal->getSalaComercial()->getGaragem() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Condomínio</div>
                                    R$ " . $modal->getSalaComercial()->getCondominio() . "
                                  </div>
                                </div>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    " . $modal->getSalaComercial()->getArea() . "
                                  </div>
                                </div>                               
                            </div>";
                        break;

                    case "5":
                        echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    " . $modal->getPredioComercial()->getArea() . "
                                  </div>
                                </div>
                              </div>";
                        break;

                    case "6":
                        echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Área m<SUP>2</SUP></div>
                                    " . $modal->getTerreno()->getArea() . "
                                  </div>
                                </div>
                              </div>";
                        break;
                }
                
                echo "<div class='ui hidden divider'></div>";
                
                //diferencial
                $totalDiferencial = count($modal->getImovelDiferencial());

                if ($totalDiferencial != 0) {
                    //transforma os elementos em um array
                    $valoresDiferencial = array();

                    foreach ($modal->getImovelDiferencial() as $valoresDif) {
                        $valoresDiferencial[] = $valoresDif->getDiferencial()->getDescricao();
                    }

                    $diferenciais = implode(", ", $valoresDiferencial);

                    echo "<div class='ui horizontal list'>
                                        <div class='item'>
                                        <div class='content'>
                                        <div class='header'>Diferenciais </div>" . $diferenciais . "</div>
                         </div>
                         </div>
            <div class='ui hidden divider'></div>";
                }

                //fim do diferencial
                
                echo "<div class='ui dividing header'></div>";

                if ($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() != "") {
                    $endereco = $modal->getEndereco()->getLogradouro() . ", " . $modal->getEndereco()->getNumero() . ", " . $modal->getEndereco()->getComplemento();
                } elseif ($modal->getEndereco()->getNumero() != "" && $modal->getEndereco()->getComplemento() == "") {
                    $endereco = $modal->getEndereco()->getLogradouro() . ", " . $modal->getEndereco()->getNumero();
                } elseif ($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() == "") {
                    $endereco = $modal->getEndereco()->getLogradouro();
                } elseif ($modal->getEndereco()->getNumero() == "" && $modal->getEndereco()->getComplemento() != "") {
                    $endereco = $modal->getEndereco()->getLogradouro() . ", " . $modal->getEndereco()->getComplemento();
                }

                echo "<div class='ui horizontal list'>
                                <div class='item'>
                                  <div class='content'>
                                    <div class='header'>Endereço</div>
                                    " . $endereco . "<br />
                                    " . $modal->getEndereco()->getBairro()->getNome() . ", " . $modal->getEndereco()->getCidade()->getNome() . " - " . $modal->getEndereco()->getEstado()->getUf() . "
                                  </div>
                                </div>                               
                          </div>";
                ?>
            </div>
        </div>
        <div class="actions">
            <div class="ui deny button">FECHAR</div>
        </div>
    </div> 

    <script>
        $(("#detalhes<?php echo $modal->getId() ?>")).click(function () {

            $("#modal<?php echo $modal->getId() ?>").modal({
                closable: true,
                transition: "fade up",
            }).modal('show');

        })
    </script>   


<?php } ?>

