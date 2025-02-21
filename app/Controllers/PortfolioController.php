<?php

namespace App\Controllers;

use App\Models\Portfolio;
use App\Models\Profile;

class PortfolioController extends BaseController
{
    public function showPortfolio($userId)
    {

        $portfolio = Portfolio::getInstancia();
        $data['portfolio'] = $portfolio->getPortfolioByUserId($userId);
        $data['isOwner'] = (isset($_SESSION['id']) && $_SESSION['id'] == $userId); // Verifica si es el dueño
        $portfolioData = $portfolio->getPortfolioByUserId($userId);
        if (empty($portfolioData)) {
            echo "No hay datos de portafolio para este usuario.";
            die();
        }

        $this->renderHTML('../app/view/welcome_view.php', $data);
    }


    
}
