cd docker
case "%1" in
    'start')
       %docker-compose -f docker-compose.yml up -d web phppgadmin
        ;;
    'stop')
        docker-compose -f docker-compose.yml stop
        ;;
    *)
        echo $"Usage: %0 {start|stop}"
esac
cd ..