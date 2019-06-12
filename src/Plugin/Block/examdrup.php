<?php
namespace Drupal\examdrup\Plugin\Block;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;/**
 * Provides a examdrup block.
 *
 * @Block(
 *  id = "examdrup_block",
 *  admin_label = @Translation("examdrup!")
 * )
 */
class examdrup extends BlockBase implements ContainerFactoryPluginInterface{

    /**
     * @var DateFormatterInterface
     */
    protected $dateFormatter;  /**
 * @var AccountProxyInterface
 */
    protected $currentUser;  /**
 * @var TimeInterface
 */
    protected $time;  /**
 * {@inheritdoc}.
 */
    public function __construct(array $configuration,
                                $plugin_id,
                                $plugin_definition,
                                DateFormatterInterface $dateFormatter,
                                AccountProxyInterface $currentUser,
                                TimeInterface $time) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->dateFormatter = $dateFormatter;
        $this->currentUser = $currentUser;
        $this->time = $time;
    }  /**
 * {@inheritdoc}.
 */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('date.formatter'),
            $container->get('current_user'),
            $container->get('datetime.time')
        );
    }  /**
 * {@inheritdoc}.
 */

    public function build() {
        $name = $this->currentUser->isAuthenticated() ? $this->currentUser->getAccountName() : $this->t('anonymous');
        $build = [
            '#markup' => $this->t('Welcome %name. It is %time.', [
                '%name' => $name,
                '%time' => $this->dateFormatter->format($this->time->getCurrentTime(), 'custom', 'H:i s\s'),
            ]),
            '#cache' => [
                'keys' => ['activesessions:block'],
                'max-age' => '10',
                'contexts' => ['user'],
            ],
        ];    return $build;
    }
}