<?php

namespace Drupal\gym_connector\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;
use Drupal\Core\Database\Database;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class UserController.
 */
class UserController extends ControllerBase
{

  private $connection;

  public function __construct(Connection $connection)
  {
    $this->connection = $connection;
  }

  /*
   * create() is a factory method for dependency injection.
   *
   * Plugins which implement ContainerFactoryPluginInterface are instantiated by create() of the plugin class:
   * ContainerFactory::createInstance
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('database')
    );
  }

  /**
   * @param $name
   * @return string[]
   */
  public function index($name): array
  {

    //echo $name;exit;
    /*return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): ').$name,
    ];*/

    $header_table = array(
      'id' => t('SrNo'),
      'name' => t('Name'),

    );

    $db = Database::getConnection('default', 'gymous');

    $query = $db
      ->select('user', 'u')
      ->fields('u', ['id', 'email'])
      ->orderBy('id','desc')
    ;
    $result = $query->execute();

    $items = array();
    /*foreach ($result as $record) {
      $items[] = $record->email;
    }*/
    foreach ($result as $record) {
      $items[] = [
        'userid' => $record->id,
        'email'=> $record->email,
      ];
    }

    //dump($items);exit;


    $header = [
      'userid' => t('User id'),
      'email' => t('Email'),
    ];

    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $items,
      '#empty' => t('No users found'),
    ];

    return $form;


    /*return [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#title' => 'My List',
      '#items' => $items
    ];*/

  }

  public function showContent(): array
  {
    //db_select is deprecated
    $select = $this->connection->select('node', 'n');
    $select->fields('n');
    $select->condition('type', "article", "=");
    $entries = $select->execute()->fetchAll(\PDO::FETCH_ASSOC);
    $article_count = count($entries);
    return [
      '#markup' => t('There are @articles articles on the current site.', ['@articles' => $article_count])
    ];
  }


}
