<?php
namespace Concrete\Package\SecretPreviewUrl\MenuItem\SecretPreviewUrl;

use Concrete\Core\Page\Page;
use Concrete\Core\Permission\Checker;
use Concrete\Core\Url\Resolver\Manager\ResolverManagerInterface;

class Controller extends \Concrete\Core\Application\UserInterface\Menu\Item\Controller
{
    public function displayItem()
    {
        $c = Page::getCurrentPage();
        if (is_object($c) && !$c->isAdminArea() && !$c->isAliasPageOrExternalLink() && !$c->isInTrash() && !$c->isMasterCollection()) {
            $cp = new Checker($c);
            if ($cp->canApprovePageVersions()) {
                /** @var ResolverManagerInterface $resolver */
                $resolver = $this->app->make(ResolverManagerInterface::class);
                $this->menuItem->setLink($resolver->resolve(['/ccm/secret_preview_url', 'dialog', $c->getCollectionID()]));
                return true;
            }
        }

        return false;
    }

}